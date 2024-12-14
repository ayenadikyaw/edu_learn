<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Components/Layouts/adminLayout.vue";
import { useToast } from "primevue/usetoast";

const props = defineProps({
    message: {
        type: Object,
        required: true
    }
});

const toast = useToast();

const form = useForm({
    reply_msg: '',
    is_replied: false
});

const sendReply = () => {
    form.put(route('admin.messages.reply', props.message.id), {
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Reply sent successfully',
                life: 3000
            });
            form.reset();
        },
        onError: () => {
            toast.add({
                severity: 'error', 
                summary: 'Error',
                detail: 'Failed to send reply',
                life: 3000
            });
        }
    });
};
</script>

<template>
    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="mb-8">
                            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Message Details</h2>
                            
                            <div class="grid grid-cols-2 gap-6 mb-6">
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">From:</p>
                                    <p class="font-medium">{{ message.first_name }} {{ message.last_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Email:</p>
                                    <p class="font-medium text-blue-600">{{ message.email }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Date:</p>
                                    <p class="font-medium">{{ new Date(message.created_at).toLocaleDateString() }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Status:</p>
                                    <span :class="[
                                        'px-3 py-1 rounded-full text-sm',
                                        message.is_replied ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'
                                    ]">
                                        {{ message.is_replied ? 'Replied' : 'Pending' }}
                                    </span>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <p class="text-sm text-gray-600 mb-2">Message:</p>
                                <p class="whitespace-pre-wrap">{{ message.message }}</p>
                            </div>

                            <div v-if="message.reply_msg" class="bg-blue-50 p-4 rounded-lg mb-6">
                                <p class="text-sm text-gray-600 mb-2">Previous Reply:</p>
                                <p class="whitespace-pre-wrap">{{ message.reply_msg }}</p>
                            </div>
                        </div>

                        <div v-if="!message.is_replied" class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Send Reply</h3>
                            <form @submit.prevent="sendReply">
                                <div class="mb-4">
                                    <textarea
                                        v-model="form.reply_msg"
                                        rows="6"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                        placeholder="Type your reply here..."
                                    ></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button
                                        type="submit"
                                        class="bg-primary hover:bg-primary/90 text-white px-6 py-2 rounded-lg flex items-center gap-2"
                                        :disabled="form.processing"
                                    >
                                        <i class="pi pi-send"></i>
                                        Send Reply
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
