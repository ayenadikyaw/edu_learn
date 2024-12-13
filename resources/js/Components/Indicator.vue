<script setup>
// Counter animation
const counters = document.querySelectorAll(".counter");
counters.forEach((counter) => {
    const target = +counter.getAttribute("data-target");
    const increment = target / 200;

    const updateCounter = () => {
        const count = +counter.innerText;
        if (count < target) {
            counter.innerText = Math.ceil(count + increment);
            setTimeout(updateCounter, 1);
        } else {
            counter.innerText = target;
        }
    };

    updateCounter();
});
</script>

<template>
    <div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-8 text-4xl">
            <!-- Total Students -->
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <i class="pi pi-users text-4xl text-primary mb-4"></i>
                <div class="text-4xl font-bold text-primary mb-2">
                    <span class="counter" data-target="15000">0</span>+
                </div>
                <h3 class="text-xl font-semibold text-gray-700">
                    Total Students
                </h3>
            </div>

            <!-- Total Courses -->
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <i class="pi pi-book text-4xl text-primary mb-4"></i>
                <div class="text-4xl font-bold text-primary mb-2">
                    <span class="counter" data-target="200">0</span>+
                </div>
                <h3 class="text-xl font-semibold text-gray-700">
                    Total Courses
                </h3>
            </div>

            <!-- Total Instructors -->
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <i class="pi pi-user text-4xl text-primary mb-4"></i>
                <div class="text-4xl font-bold text-primary mb-2">
                    <span class="counter" data-target="50">0</span>+
                </div>
                <h3 class="text-xl font-semibold text-gray-700">
                    Total Instructors
                </h3>
            </div>
        </div>
    </div>
</template>
