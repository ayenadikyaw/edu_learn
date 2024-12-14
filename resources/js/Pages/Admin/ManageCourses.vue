<script setup>
import { ref, onMounted } from "vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import { useConfirm } from "primevue/useconfirm";
import ConfirmDialog from "primevue/confirmdialog";
import { useToast } from "primevue";
import AdminLayout from "@/Components/Layouts/adminLayout.vue";
const props = defineProps({
    courses: Array,
    lessons: Array,
});
console.log(props.courses);

const confirmation = useConfirm();
const toast = useToast();

const courseCategories = ref([]);
const courseLevels = ref([]);

onMounted(async () => {
    const { data } = await axios.get("/api/course_categories");
    courseCategories.value = data;
    const { data: levelsData } = await axios.get("/api/course_levels");
    courseLevels.value = levelsData;

});

const deleteCourse = (courseId) => {
    confirmation.require({
        group: "headless",
        header: "Are you sure?",
        message: "Please confirm to proceed.",
        accept: () => {
            toast.add({
                severity: "info",
                summary: "Confirmed",
                detail: "You have accepted",
                life: 3000,
            });
            router.delete(route("admin.delete-course", { course: courseId }));
        },
        reject: () => {
            toast.add({
                severity: "error",
                summary: "Rejected",
                detail: "You have rejected",
                life: 3000,
            });
        },
    });
};
</script>

<template>
    <AdminLayout>
    <ConfirmDialog group="headless">
        <template #container="{ message, acceptCallback, rejectCallback }">
            <div
                class="flex flex-col items-center p-6 bg-white rounded-lg shadow-lg"
            >
                <div
                    class="rounded-full bg-red-500 text-white inline-flex justify-center items-center h-16 w-16 -mt-14"
                >
                    <i class="pi pi-exclamation-triangle text-3xl"></i>
                </div>
                <span class="font-bold text-xl text-gray-800 block mb-3 mt-4">{{
                    message.header
                }}</span>
                <p class="text-gray-600 mb-4 text-center">
                    {{ message.message }}
                </p>
                <div class="flex items-center gap-3 mt-2">
                    <Button
                        label="Delete"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md"
                        @click="acceptCallback"
                        >Yes</Button
                    >
                    <Button
                        label="Cancel"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md"
                        @click="rejectCallback"
                        >No</Button
                    >
                </div>
            </div>
        </template>
    </ConfirmDialog>
    <div class="card flex justify-center">
        <Button @click="requireConfirmation()" label="Save"></Button>
    </div>
    <Toast />

    <div>
        <!--table-->
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Manage Courses</h2>
            <button
                @click="router.visit('/admin/add-course')"
                class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg flex items-center gap-2"
            >
                <i class="pi pi-plus"></i>
                Add New Course
            </button>
        </div>
        <div class="w-full">
            <div class="overflow-x-auto">
                <DataTable
                    :value="courses"
                    class="w-full p-4 text-sm border-none bg-white rounded-lg shadow-md overflow-hidden"
                    scrollable
                    :header="false"
                    columnResizeMode="expand"
                    :rows="10"
                    :rowsPerPageOptions="[10, 20, 50]"
                    :totalRecords="courses.length"
                    responsiveLayout="scroll"
                    breakpoint="sm"
                    paginator
                >
                    <!--Image-->
                    <Column field="image" header="Course" class="w-[15%] h-12" :sortable="true">
                        <template #body="slotProps">
                            <div class="flex items-center gap-4 p-2">
                                <img
                                    :src="slotProps.data.profile_image ? slotProps.data.profile_image : '/assets/images/defaultCourse1.jpg'"
                                    alt="product image"
                                    class="w-16 h-16 object-cover rounded-lg shadow-sm"
                                />
                                <div>
                                    <div class="font-bold text-gray-800">
                                        {{ slotProps.data.title }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{
                                            slotProps.data.description.substring(
                                                0,
                                                50
                                            )
                                        }}...
                                    </div>
                                </div>
                            </div>
                        </template>
                    </Column>
                    <!--Lessons Count-->
                    <Column field="lessons" header="Lessons" class="w-[10%]">
                        <template #body="slotProps">
                            <div class="flex items-center gap-2 p-2">
                                <div
                                    class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center"
                                >
                                    <i class="pi pi-book text-primary"></i>
                                </div>
                                <span class="font-semibold"
                                    >{{
                                        slotProps.data.lessons.length
                                    }}
                                    Lessons</span
                                >
                            </div>
                        </template>
                    </Column>
                    <!--Price-->
                    <Column field="price" header="Price" class="w-[10%]">
                        <template #body="slotProps">
                            <div class="p-2">
                                <span class="font-bold text-primary"
                                    >${{ slotProps.data.price }}</span
                                >
                            </div>
                        </template>
                    </Column>
                    <!--Category-->
                    <Column field="category" header="Category" class="w-[10%]">
                        <template #body="slotProps">
                            <div class="p-2">
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium"
                                >
                                    {{
                                        courseCategories.find(
                                            (category) =>
                                                category.id ===
                                                slotProps.data.category_id
                                        )?.name
                                    }}
                                </span>
                            </div>
                        </template>
                    </Column>
                    <!--Level-->
                    <Column field="level" header="Level" class="w-[10%]">
                        <template #body="slotProps">
                            <div class="p-2">
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium"
                                >
                                    {{
                                        courseLevels.find(
                                            (level) =>
                                                level.id ===
                                                slotProps.data.level_id
                                        )?.name
                                    }}
                                </span>
                            </div>
                        </template>
                    </Column>
                    <!--Status-->
                    <Column field="status" header="Status" class="w-[10%]">
                        <template #body="slotProps">
                            <div class="p-2">
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium"
                                    :class="{
                                        'bg-primary/10 text-primary':
                                            slotProps.data.status === 1,
                                        'bg-green-100 text-green-700':
                                            slotProps.data.status === 0,
                                    }"
                                >
                                    {{
                                        slotProps.data.status === 1
                                            ? "Published"
                                            : "Unpublished"
                                    }}
                                </span>
                            </div>
                        </template>
                    </Column>
                    <!--Action-->
                    <Column
                        field="action"
                        header="Actions"
                        class="w-[10%]"
                        alignFrozen="right"
                        frozen
                    >
                        <template #body="slotProps">
                            <div class="flex gap-2 p-2">
                                <Link
                                    :href="
                                        route('admin.edit-course', {
                                            course: slotProps.data,
                                        })
                                    "
                                    class="w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-full flex items-center justify-center transition-colors"
                                >
                                    <i class="pi pi-pencil"></i>
                                </Link>
                                <button
                                    @click="deleteCourse(slotProps.data.id)"
                                    class="w-8 h-8 text-red-600 hover:bg-red-50 rounded-full flex items-center justify-center transition-colors"
                                >
                                    <i class="pi pi-trash"></i>
                                </button>
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </div>
    </AdminLayout>
</template>

<style scoped>
:deep(.p-datatable-paginator-bottom) {
    border: none !important;
    margin-top: 1rem;
    :deep(.p-paginator-pages .p-paginator-page) {
        margin: 0.5rem 0.5rem;
    }
    :deep(.p-paginator-prev),
    :deep(.p-paginator-next) {
        margin: 0.5rem 0.5rem;
    }

    :deep(.p-select) {
        margin-left: 1rem;
    }
}
/* Custom Toast Styling */
:deep(.p-toast) {
    opacity: 1 !important;
}

:deep(.p-toast .p-toast-message) {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

:deep(.p-toast .p-toast-message.p-toast-message-success) {
    background: #ecfdf5;
    border-left: 6px solid #10b981;
    color: #064e3b;
}

:deep(.p-toast .p-toast-message.p-toast-message-error) {
    background: #fef2f2;
    border-left: 6px solid #ef4444;
    color: #7f1d1d;
}

:deep(.p-toast .p-toast-message .p-toast-message-content) {
    padding: 1rem;
}

:deep(.p-toast .p-toast-message .p-toast-summary) {
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0.25rem;
}

:deep(.p-toast .p-toast-message .p-toast-detail) {
    font-size: 0.875rem;
}

:deep(.p-toast .p-toast-icon-close ){
    width: 2rem;
    height: 2rem;
    border-radius: 4px;
    background: transparent;
    color: currentColor;
    transition: background-color 0.2s;
}

:deep(.p-toast .p-toast-icon-close):hover {
    background: rgba(0, 0, 0, 0.05);
}
</style>
