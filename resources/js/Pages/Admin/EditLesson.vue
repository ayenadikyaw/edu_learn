<script setup>
import { ref, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { QuillEditor } from "@vueup/vue-quill";
import { useToast } from "primevue/usetoast";
import AdminLayout from "@/Components/Layouts/adminLayout.vue";
import { Link } from "@inertiajs/vue3";
const props = defineProps({
    lesson: {
        type: Object,
        required: true,
    },
});

const toast = useToast();

const form = useForm({
    title: props.lesson.title,
    content: props.lesson.content,
    _method: "PUT",
});

const editorOptions = {
    modules: {
        toolbar: [
            ["bold", "italic", "underline", "strike"],
            ["blockquote", "code-block"],
            [{ header: 1 }, { header: 2 }],
            [{ list: "ordered" }, { list: "bullet" }],
            [{ script: "sub" }, { script: "super" }],
            [{ indent: "-1" }, { indent: "+1" }],
            ["link", "image", "video"],
            ["clean"],
        ],
    },
    placeholder: "Write lesson content here...",
};

const submit = () => {
    form.post(route("admin.update-lesson", props.lesson.id), {
        onSuccess: () => {
            toast.add({
                severity: "success",
                summary: "Success",
                detail: "Lesson updated successfully",
                life: 3000,
            });
        },
    });
};
</script>

<template>
    <AdminLayout>
        <Link
            :href="route('admin.edit-course', props.lesson.course_id)"
            class="flex items-center gap-2 text-primary hover:text-primary/90"
        >
            <span class="pi pi-arrow-left text-2xl"></span>
            Back</Link
        >
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold mb-6">Edit Lesson</h2>

                        <form @submit.prevent="submit">
                            <div class="mb-6">
                                <InputLabel for="title" value="Lesson Title" />
                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                    required
                                />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Lesson Content</label
                                >
                                <QuillEditor
                                    v-model:content="form.content"
                                    :options="editorOptions"
                                    theme="snow"
                                    contentType="html"
                                    class="h-96 text-sm mb-12 overflow-scroll"
                                />
                            </div>

                            <div
                                class="flex items-center justify-end mt-6 relative z-10"
                            >
                                <button
                                    @click="submit"
                                    class="bg-primary text-white px-4 py-2 rounded-md cursor-pointer flex items-center gap-2"
                                >
                                    <i class="pi pi-check"></i>Update Lesson
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
