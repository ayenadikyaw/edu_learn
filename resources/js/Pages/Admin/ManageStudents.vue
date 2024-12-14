<script setup>
import { ref, onMounted } from "vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { useConfirm } from "primevue/useconfirm";
import ConfirmDialog from "primevue/confirmdialog";
import { useToast } from "primevue";
import AdminLayout from "@/Components/Layouts/adminLayout.vue";

const props = defineProps({
    students: Array,
});
console.log(props.students);

const confirmation = useConfirm();
const toast = useToast();

const deleteStudent = (studentId) => {
    confirmation.require({
        group: "headless",
        header: "Are you sure?",
        message: "Please confirm to proceed with student deletion.",
        accept: () => {
            toast.add({
                severity: "info",
                summary: "Confirmed",
                detail: "You have accepted",
                life: 3000,
            });
            router.delete(
                route("admin.delete-student", { student: studentId })
            );
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
                    <span
                        class="font-bold text-xl text-gray-800 block mb-3 mt-4"
                        >{{ message.header }}</span
                    >
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
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">Manage Students</h2>
            </div>
            <div class="w-full">
                <div class="overflow-x-auto">
                    <DataTable
                        :value="students"
                        class="w-full p-4 text-sm border-none bg-white rounded-lg shadow-md overflow-hidden"
                        scrollable
                        :header="false"
                        columnResizeMode="expand"
                        :rows="10"
                        :rowsPerPageOptions="[10, 20, 50]"
                        :totalRecords="students.length"
                        responsiveLayout="scroll"
                        breakpoint="sm"
                        paginator
                    >
                        <!-- Profile Image & Name -->
                        <Column field="name" header="Student" class="w-[25%]">
                            <template #body="slotProps">
                                <div class="flex items-center gap-4 p-2">
                                    <img
                                        :src="
                                            slotProps.data.profile_image
                                                ? slotProps.data.profile_image
                                                : '/assets/images/user.png'
                                        "
                                        alt="student profile"
                                        class="w-12 h-12 object-cover rounded-full shadow-sm"
                                    />
                                    <div>
                                        <div class="font-bold text-gray-800">
                                            {{ slotProps.data.name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ slotProps.data.email }}
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </Column>

                        <!-- Enrolled Courses -->
                        <Column
                            field="courses"
                            header="Enrolled Courses"
                            class="w-[20%]"
                        >
                            <template #body="slotProps">
                                <div class="flex items-center gap-2 p-2">
                                    <div
                                        class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center"
                                    >
                                        <i class="pi pi-book text-primary"></i>
                                    </div>
                                    <span class="font-semibold"
                                        >{{
                                            slotProps.data.enrollments_count
                                        }}
                                        Courses</span
                                    >
                                </div>
                            </template>
                        </Column>

                        <!-- Join Date -->
                        <Column
                            field="created_at"
                            header="Join Date"
                            class="w-[15%]"
                        >
                            <template #body="slotProps">
                                <div class="p-2">
                                    {{
                                        new Date(
                                            slotProps.data.created_at
                                        ).toLocaleDateString()
                                    }}
                                </div>
                            </template>
                        </Column>

                        <!-- Actions -->
                        <Column
                            field="actions"
                            header="Actions"
                            class="w-[15%]"
                        >
                            <template #body="slotProps">
                                <div class="flex items-center gap-2 p-2">
                                    <button
                                        @click="
                                            deleteStudent(slotProps.data.id)
                                        "
                                        class="p-2 text-red-600 hover:text-red-800"
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

:deep(.p-toast .p-toast-icon-close) {
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
