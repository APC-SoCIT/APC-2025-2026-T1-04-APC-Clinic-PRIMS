<x-app-layout>
    <!DOCTYPE html>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Main Container -->
    <div class="max-w-screen-2xl mx-auto mt-6 px-8">
        
        <!-- Yellow Header Section -->
    <div class="bg-[#F4C04D] h-[250px] w-full flex justify-center items-start pt-8">
        <h2 class="text-4xl font-bold text-[#1D3557] mt-2">ABOUT US</h2>
    </div>

        <!-- White Content Box -->
        <div class="bg-white shadow-lg px-10 py-8 mt-0 max-w-[100%] mx-auto">

        <!-- Image Section (Centered & Overlapping) -->
        <div class="flex justify-center -mt-40 mb-6 relative z-10">
            <img src="/img/aboutus123.png" alt="About Us Image" class="w-[80%] rounded-lg shadow-lg mx-auto">
        </div>

                
            <div class="flex justify-center items-center text-center px-10">
        <div class="max-w-3xl custom-justify">
            <p class="text-lg leading-relaxed">
            Asia Pacific College (APC) is introducing the APC Clinic which serves as the primary healthcare provider at this college, dedicated to meeting the medical needs of its students, faculty, and staff. We are committed to delivering accessible, high-quality healthcare services that support the well-being of our academic community.              </p>

            <br>
            <p class="text-lg leading-relaxed">
            Our clinic provides a range of essential medical services, including free medical checkups, blood pressure monitoring, and access to necessary medications. This ensures that quality care remains within the reach of all. With our continuous effort to enhance campus healthcare, we are pleased to announce the upcoming addition of dental checkups as part of our expanding services.            </p>

            <br>
            <p class="text-lg leading-relaxed">
            At APC Clinic, we prioritize preventive care and wellness, creating a safe and supportive environment where healthcare is readily available. We are dedicated to providing compassionate, student-centered care, whether it is for routine consultations or urgent medical assistance, in order to help our community stay healthy and focused on their academic pursuits.            </p>
        </div>
    </div>

                <!-- Black Divider Line -->
                <div class="border-t-2 border-black w-full my-6"></div>

                <!-- Mission | Vision | Values -->
                <div class="grid grid-cols-3 gap-6 text-center text-gray-700">

                    <!-- Mission -->
                    <div>
                        <h3 class="text-xl font-bold text-[#1D3557]">Mission</h3>
                        <p class="text-md mt-2 custom-justify leading-relaxed">
                        Asia Pacific College, powered by education and industry professionals as faculty and a balanced curriculum, 
                        aims to provide business and the information and communications technology industry in the Philippines and in 
                        the global community lifelong learning graduates who are anchored on the principles of integrity and professionalism.
                        </p>
                    </div>

                    <!-- Vision -->
                    <div>
                        <h3 class="text-xl font-bold text-[#1D3557]">Vision</h3>
                        <p class="text-md mt-2 custom-justify leading-relaxed">
                        Asia Pacific College envisions itself to be the preferred Higher 
                        Education Institution bridging academe and industry with its programs founded on the 
                        concepts and applications of IT, guided by the core values of integrity, industry and innovation that works.
                        </p>
                    </div>

                    <style>
                        .custom-justify {
                            text-align: justify;
                        }
                    </style>

                    <!-- Values -->
                    <div>
                        <h3 class="text-xl font-bold text-[#1D3557]">Values</h3>
                        <p class="text-md mt-2 custom-justify leading-relaxed">
                        APC aims to produce graduates with strong sense of industry or hard work, integrity or being honest and having strong 
                        moral / ethical principles, and innovation or constantly introducing new and creative methods or ideas.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </body>
    </html>

    <footer class="bg-prims-yellow-1 w-full h-16 mt-6 flex items-center pl-6 relative">
        <img src="img/APC_LOGO_SEAL.png" class="object-scale-down h-10">
        <p class="absolute inset-0 flex items-center justify-center w-full">
        Copyright © 2025<span class="ml-1 text-blue-500">Asia Pacific College</span>. All Rights Reserved.
        </p>
        </footer>

</x-app-layout>
