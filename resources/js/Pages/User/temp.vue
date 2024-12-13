    <Head title="Dashboard" />
  <template>
  <AuthHeader />

    <maind class="min-h-screen bg-gray-50">
        <!-- Current Course Section -->
        <section class="py-12 bg-gradient-to-b from-primary/5 to-transparent">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8 mt-16">Continue Learning</h2>
                
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <img src="/images/course-placeholder.jpg" alt="Course thumbnail" class="w-full md:w-64 h-40 object-cover rounded-lg"/>
                        
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold mb-2">Web Development Fundamentals</h3>
                            <div class="flex items-center text-sm text-gray-600 mb-4">
                                <i class="pi pi-clock mr-2"></i>
                                <span>Progress: 60%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                                <div class="bg-primary h-2.5 rounded-full" style="width: 60%"></div>
                            </div>
                            <button class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                                Go to Course
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Completed Courses -->
        <section class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Completed Courses</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <img src="/images/course-1.jpg" alt="Course" class="w-full h-48 object-cover rounded-lg mb-4"/>
                        <h3 class="text-lg font-semibold mb-2">Introduction to Python</h3>
                        <div class="flex items-center text-sm text-green-600 mb-4">
                            <i class="pi pi-check-circle mr-2"></i>
                            <span>Completed</span>
                        </div>
                        <button class="text-primary hover:text-primary/80 font-medium">
                            View Certificate
                        </button>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <img src="/images/course-2.jpg" alt="Course" class="w-full h-48 object-cover rounded-lg mb-4"/>
                        <h3 class="text-lg font-semibold mb-2">UI/UX Fundamentals</h3>
                        <div class="flex items-center text-sm text-green-600 mb-4">
                            <i class="pi pi-check-circle mr-2"></i>
                            <span>Completed</span>
                        </div>
                        <button class="text-primary hover:text-primary/80 font-medium">
                            View Certificate
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 rounded-xl p-6 text-center">
                        <div class="text-4xl font-bold text-primary mb-2">3</div>
                        <div class="text-gray-600">Courses Completed</div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-6 text-center">
                        <div class="text-4xl font-bold text-primary mb-2">24</div>
                        <div class="text-gray-600">Hours Learned</div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-6 text-center">
                        <div class="text-4xl font-bold text-primary mb-2">12</div>
                        <div class="text-gray-600">Certificates Earned</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Course Carousel -->
        <section class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Recommended Courses</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <img src="/images/course-3.jpg" alt="Course" class="w-full h-48 object-cover rounded-lg mb-4"/>
                        <h3 class="text-lg font-semibold mb-2">Advanced JavaScript</h3>
                        <p class="text-gray-600 text-sm mb-4">Master modern JavaScript concepts and practices</p>
                        <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors w-full">
                            Enroll Now
                        </button>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <img src="/images/course-4.jpg" alt="Course" class="w-full h-48 object-cover rounded-lg mb-4"/>
                        <h3 class="text-lg font-semibold mb-2">Data Science Basics</h3>
                        <p class="text-gray-600 text-sm mb-4">Learn fundamentals of data analysis and visualization</p>
                        <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors w-full">
                            Enroll Now
                        </button>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <img src="/images/course-5.jpg" alt="Course" class="w-full h-48 object-cover rounded-lg mb-4"/>
                        <h3 class="text-lg font-semibold mb-2">Mobile App Development</h3>
                        <p class="text-gray-600 text-sm mb-4">Build cross-platform mobile applications</p>
                        <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors w-full">
                            Enroll Now
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <Footer />
    </maind>

</template>
