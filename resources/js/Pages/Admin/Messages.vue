<script setup>
import { Head } from "@inertiajs/vue3";
import AdminLayout from "@/Components/Layouts/adminLayout.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import DataTable from "primevue/datatable";
import Column from "primevue/column";

const props = defineProps({
    messages: {
        type: Array,
        required: true,
    },
});

const messages = ref(props.messages);
console.log(messages.value);

const form = useForm({
    id: "",
    reply_msg: "",
    is_replied: false,
});

const deleteMessage = (id) => {
    if (confirm("Are you sure you want to delete this message?")) {
        form.delete(route("admin.messages.destroy", id), {
            preserveScroll: true,
            onSuccess: () => {
                messages.value = messages.value.filter(
                    (message) => message.id !== id
                );
            },
        });
    }
};

const viewMessage = (message) => {
    form.get(route("admin.messages.show", message.id));
};
</script>

<template>
    <AdminLayout>
        <Head title="Messages" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                            Messages
                        </h2>

                        <DataTable
                            :value="messages"
                            :paginator="true"
                            :rows="10"
                            class="p-datatable-sm"
                            responsiveLayout="scroll"
                            :rowHover="true"
                            filterDisplay="menu"
                            :loading="false"
                            stripedRows
                        >
                            <Column
                                field="first_name"
                                header="First Name"
                                :sortable="true"
                            >
                                <template #body="slotProps">
                                    <span class="font-semibold">{{
                                        slotProps.data.first_name
                                    }}</span>
                                </template>
                            </Column>
                            <Column
                                field="last_name"
                                header="Last Name"
                                :sortable="true"
                            >
                                <template #body="slotProps">
                                    <span class="font-semibold">{{
                                        slotProps.data.last_name
                                    }}</span>
                                </template>
                            </Column>
                            <Column field="email" header="Email">
                                <template #body="slotProps">
                                    <span class="text-blue-600">{{
                                        slotProps.data.email
                                    }}</span>
                                </template>
                            </Column>
                            <Column field="message" header="Message">
                                <template #body="slotProps">
                                    <div class="max-w-xs truncate">
                                        {{ slotProps.data.message }}
                                    </div>
                                </template>
                            </Column>
                            <Column
                                field="is_replied"
                                header="Status"
                                :sortable="true"
                            >
                                <template #body="slotProps">
                                    <span
                                        :class="[
                                            'px-3 py-1 rounded-full text-sm',
                                            slotProps.data.is_replied
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-yellow-100 text-yellow-800',
                                        ]"
                                    >
                                        {{
                                            slotProps.data.is_replied
                                                ? "Replied"
                                                : "Pending"
                                        }}
                                    </span>
                                </template>
                            </Column>
                            <Column
                                field="created_at"
                                header="Date"
                                :sortable="true"
                            >
                                <template #body="slotProps">
                                    <span class="text-gray-600">{{
                                        new Date(
                                            slotProps.data.created_at
                                        ).toLocaleDateString()
                                    }}</span>
                                </template>
                            </Column>
                            <Column field="reply_msg" header="Reply Message">
                                <template #body="slotProps">
                                    <div
                                        class="max-w-xs truncate text-gray-600"
                                    >
                                        {{ slotProps.data.reply_msg || "-" }}
                                    </div>
                                </template>
                            </Column>
                            <Column field="actions" header="Actions">
                                <template #body="slotProps">
                                    <div class="flex gap-2">
                                        <button
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-full"
                                            @click="viewMessage(slotProps.data)"
                                        >
                                            <i class="pi pi-eye"></i>
                                        </button>
                                        <button
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-full"
                                            @click="
                                                deleteMessage(slotProps.data.id)
                                            "
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
