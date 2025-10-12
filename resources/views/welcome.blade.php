@section('title', 'PRIMS')

<x-app-layout>
        <div class="background-section h-[calc(100vh-4rem)] bg-cover bg-center relative bg-blend-overlay bg-prims-azure-900 bg-opacity-60" style="background-image: url(img/clinic_front.jpg);">
            <div class="relative w-2/5 h-full flex flex-col justify-center ml-40 font-nunito">

                <!-- logo -->
                <img src="img/homepage-logo.svg" class="w-1/2 my-6">

                <!-- System Name -->
                <p class="text-lg font-bold" style="color: #F4BF4F; margin-bottom: 0;">Patient Record Interactive Management System</p>

                <!-- text -->
                <p class="my-6 text-xl text-white">“The <span class="shadow-md">preservation</span> of <strong>HEALTH</strong> is easier than the <strong>CURE</strong> of the disease.”</p>

                <!-- buttons -->
                <div class="relative flex flex-row items-center">
                    <x-prims-main-button href="/appointment" class="my-6">Set an Appointment</x-prims-main-button>
                </div> 
            </div>
        </div>

        <div class="-mt-20 relative w-[70%] mx-auto">
            <div class="container mx-auto grid grid-cols-4 gap-x-6 text-white">

                <!-- Schedule -->
                <div class="flex flex-col rounded-[2rem] bg-prims-yellow-1 py-8 px-6">
                    <h3 class="text-3xl font-extrabold mb-4">Schedule</h3>
                    <h4 class="text-md font-semibold">Medical Doctor</h4>
                    <p class="text-sm font-light mb-4">Thursday: 2:00 PM to 5:00 PM</p>
                    <h4 class="text-md font-semibold">Dentist</h4>
                    <p class="text-sm font-light mb-4">Tuesday: 2:00 PM to 5:00 PM <br /> Thursday: 2:00 PM to 5:00 PM </p>
                    <h4 class="text-md font-semibold">Nurse</h4>
                    <p class="text-sm font-light">Mon – Thurs: 8:00 AM to 6:00 PM <br /> Friday: 8:00 AM to 5:00 PM <br /> Saturday: 8:00 AM to 12:00 NN</p>
                </div>

                <!-- Services -->
                <div class="flex flex-col rounded-[2rem] bg-prims-yellow-1 py-8 px-6">
                    <h3 class="text-3xl font-extrabold mb-4">Services</h3>
                    <h4 class="text-md font-semibold">Medical Consultation</h4>
                    <p class="text-sm font-light mb-4">Health assessments and treatment of minor illnesses.</p>
                    <h4 class="text-md font-semibold">Dental Services</h4>
                    <p class="text-sm font-light mb-4">Checkups, cleaning, and basic dental care.</p>
                    <h4 class="text-md font-semibold">First Aid and Emergency Care</h4>
                    <p class="text-sm font-light">Immediate response for injuries or urgent health concerns.</p>
                </div>

                <!-- Questions -->
                <div class="flex flex-col rounded-[2rem] bg-prims-yellow-1 py-8 px-6">
                    <h3 class="text-3xl font-extrabold mb-3">Questions</h3>
                    <h5 class="text-md">If you have any questions or concerns, you may message Nurse Ana Mae Torre on Teams or simply 
                    book an appointment to address your needs immediately.</h5>
                    <div class="flex justify-end">
                    </div>
                </div>

                <!-- About Us -->
                <div class="flex flex-col rounded-[2rem] bg-prims-yellow-1 py-8 px-6">
                    <h3 class="text-3xl font-extrabold mb-3">About Us</h3>
                    <h5 class="text-md">Learn about the APC-Clinic including its facilities and personnel.</h5>
                    <div class="flex justify-end">
                    <x-prims-sub-button1 href="{{ url('/about-us') }}" class="my-6">About Us</x-prims-sub-button1>                 </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-12 w-[70%] py-12 mx-auto">
            <div class="w-[45%]">
                <img src="img/bpcheck123.png" class="object-cover rounded-lg">
            </div>
            <div class="flex flex-col w-[50%] text-left">
                <p class="font-bold text-4xl mb-6">We care for you.</p>
                <p class="text-lg text-justify">
            At APC Clinic, we are dedicated to providing quality and accessible healthcare services to our community.
            Our clinic offers free checkups, including blood pressure monitoring and COVID-19 testing, ensuring that everyone
            has access to essential health screenings. In addition, we are excited to announce that our dental clinic will be
            launching soon to expand our services further. <br><br>
            Committed to promoting wellness and preventive care, APC Clinic strives to create a healthier environment for all.
            Visit us today and experience compassionate care at no cost!</p>
            </div>
        </div>

        <footer class="bg-prims-yellow-1 w-full h-16 flex items-center pl-6 relative">
        <img src="img/apc-logo.svg" class="object-scale-down h-16">
        <p class="absolute inset-0 flex items-center justify-center w-full">
        Copyright © 2025<span class="ml-1 text-blue-500">Asia Pacific College</span>. All Rights Reserved.
        </p>
        </footer>
        
</x-app-layout>
