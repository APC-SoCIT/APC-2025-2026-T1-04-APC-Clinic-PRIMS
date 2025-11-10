<div class="pb-5 flex gap-3">
    <div class="w-1/4 bg-white rounded-md shadow-md mt-5 p-6">
        <div class="flex align-items-center gap-2">
            <i class="material-icons text-light-blue-1">info_outline</i>
            <h2 class="font-bold">Patient Information</h2>
        </div>
        <hr class="my-3"/>
        <div class="text-sm">
            <p><span class="font-semibold">ID Number: </span>2022-140224</p>
            <p><span class="font-semibold">Name: </span>Shannelien Mae M. Catingub</p>
            <p><span class="font-semibold">Gender: </span>Female</p>
            <p><span class="font-semibold">Date of Birth: </span>12/29/2003</p>
            <p><span class="font-semibold">Age: </span>21</p>
            <br>
            <p><span class="font-semibold">Nationality: </span>Filipino</p>
            <p><span class="font-semibold">Blood Type: </span>O</p>
            <p><span class="font-semibold">Civil Status: </span>Single</p>
            <p><span class="font-semibold">Religion: </span>Catholic</p>
            <br>
            <p><span class="font-semibold">Contact Number: </span>09761164892</p>
            <p><span class="font-semibold">Email Address: </span>smcatingub@student.apc.edu.ph</p>
            <p><span class="font-semibold">House/Unit No.: </span>60</p>
            <p><span class="font-semibold">Street: </span>J. Fernandez St.</p>
            <p><span class="font-semibold">Barangay: </span>Pinagbuhatan</p>
            <p><span class="font-semibold">City/Municipality: </span>Pasig City</p>
            <p><span class="font-semibold">Province: </span>NCR</p>
            <p><span class="font-semibold">ZIP Code: </span>1602</p>
            <p><span class="font-semibold">Country: </span>Philippines</p>
            <br>
            <p><span class="font-semibold">Emergency Contact Name: </span>Emergency</p>
            <p><span class="font-semibold">Emergency Contact Number: </span>09123456789</p>
            <p><span class="font-semibold">Relationship to Patient: </span>Parent</p>
        </div>
    </div>

    <div class="w-3/4 mx-auto mt-5 bg-white rounded-md shadow-md p-8">
        <!-- Progress bar -->
        <div class="relative mb-5 flex justify-center">
            <ol class="relative z-10 flex w-[80%] justify-center">
                @php
                    $steps = [
                        1 => 'Medical Concern',
                        2 => 'Medical History',
                        3 => 'Physical Exam',
                        4 => 'Diagnosis',
                        5 => 'Prescription'
                    ];
                @endphp

                @foreach ($steps as $index => $label)
                    <li class="flex flex-col items-center text-center w-1/5">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 
                            {{ $step >= $index ? 'bg-light-blue-1 border-blue-500 text-white' : 'bg-white border-gray-300 text-gray-500' }}
                            transition-all duration-300">
                            {{ $index }}
                        </div>
                        <span class="mt-2 text-sm {{ $step >= $index ? 'text-blue-600 font-semibold' : 'text-gray-500' }}">
                            {{ $label }}
                        </span>
                    </li>
                @endforeach
            </ol>
        </div>

        <!-- Navigation buttons -->
        <div class="flex justify-between mb-5">
            @if ($step > 1)
                <button type="button" wire:click="previousStep"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                    Previous
                </button>
            @endif
            @if ($step < count($steps))
                <button type="button" wire:click="nextStep"
                    class="ml-auto bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                    Next
                </button>
            @else
                <button type="submit"
                    class="ml-auto bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                    Save Record
                </button>
            @endif
        </div>

        <!-- Form content -->
        <form wire:submit.prevent="save">
            @if ($step === 1)
                <div>
                    <h2 class="font-bold mb-4">Medical Concern</h2>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Visit: <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-5 gap-3">
                            @foreach (['Consultation', 'Fever', 'Headache', 'Injury', 'Other'] as $option)
                                <button 
                                    type="button"
                                    wire:click="$set('reason', '{{ $option }}')"
                                    class="px-4 py-2 border rounded-md text-sm font-medium transition
                                    {{ $reason === $option 
                                        ? 'bg-blue-500 text-white border-blue-500' 
                                        : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                                    {{ $option }}
                                </button>
                            @endforeach
                        </div>
                        @error('reason') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Description of Symptoms: <span class="text-red-500">*</span></label>
                        <textarea wire:model.defer="description" rows="2" class="text-gray-700 text-sm mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Enter description of symptoms..." required></textarea>
                        @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            @elseif ($step === 2)
                <div class="flex items-start gap-2">
                    <!-- Left sidebar: sub-steps -->
                    <div class="w-1/4 p-2 rounded-md">
                        @php
                            $substeps = [
                                1 => 'Past Medical',
                                2 => 'Family',
                                3 => 'Personal',
                                4 => 'OB-Gyne',
                                5 => 'Hospitalization',
                                6 => 'Operation',
                                7 => 'Immunizations'
                            ];
                        @endphp

                        <ol class="space-y-1">
                            @foreach ($substeps as $subIndex => $label)
                                <li>
                                    <button 
                                        type="button"
                                        wire:click="$set('substep', {{ $subIndex }})"
                                        class="w-full text-left px-3 py-2 font-medium transition
                                        {{ $substep === $subIndex 
                                            ? 'font-semibold text-md border-l-4 border-blue-500' 
                                            : 'text-gray-500 text-sm hover:bg-gray-50 hover:rounded-md' }}">
                                        {{ $label }}
                                    </button>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <!-- Right content -->
                    <div class="flex-1 rounded-md bg-gray-50 p-4 rounded-lg">
                        @if ($substep === 1)
                            <div>
                                <h3 class="text-lg font-semibold text-blue-700 mb-3">Past Medical History</h3>
                                <div class="mb-2">
                                    <label class="block text-sm font-medium text-gray-700">Medications:</label>
                                    <textarea wire:model.defer="medications" rows="2" class="text-gray-700 text-sm mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="List any current or past medications, including maintenance prescriptions..."></textarea>
                                </div>
                                <div class="mb-2">
                                    <label class="block text-sm font-medium text-gray-700">Allergies:</label>
                                    <textarea wire:model.defer="allergies" rows="2" class="text-gray-700 text-sm mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Specify any known drug, food, or environmental allergies..."></textarea>
                                </div>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <!-- Column 1 -->
                                    <div class="space-y-2">
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" wire:model.defer="past_medical_history.Mumps" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span>Mumps</span>
                                        </label>

                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" wire:model.defer="past_medical_history.Heart Disorder" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span>Heart Disorder</span>
                                        </label>

                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" wire:model.defer="past_medical_history.Bleeding Problem" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span>Bleeding Problem</span>
                                        </label>

                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" wire:model.defer="past_medical_history.Chicken Pox" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span>Chicken Pox</span>
                                        </label>
                                    </div>

                                    <!-- Column 2 -->
                                    <div class="space-y-2">
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" wire:model.defer="past_medical_history.Dengue" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span>Dengue</span>
                                        </label>

                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" wire:model.defer="past_medical_history.Kidney Disease" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span>Kidney Disease</span>
                                        </label>

                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" wire:model.defer="past_medical_history.Covid-19" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span>COVID-19</span>
                                        </label>

                                        <label class="flex items-center space-x-2">
                                            <span>Hepatitis</span>
                                            <button 
                                                type="button" 
                                                wire:click="$set('past_medical_history.Hepatitis', null)" 
                                                class="text-gray-400 hover:text-red-500 transition"
                                                title="Clear selection">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="w-4 h-4" fill="currentColor"><path d="M690-240h190v80H610l80-80Zm-500 80-85-85q-23-23-23.5-57t22.5-58l440-456q23-24 56.5-24t56.5 23l199 199q23 23 23 57t-23 57L520-160H190Zm296-80 314-322-198-198-442 456 64 64h262Zm-6-240Z"/></svg>
                                            </button>
                                        </label>
                                        <div class="flex items-center space-x-4">
                                            <label class="flex items-center space-x-1">
                                                <input type="radio" wire:model="past_medical_history.Hepatitis" value="A" class="text-blue-600 border-gray-300 focus:ring-blue-500">
                                                <span>A</span>
                                            </label>
                                            <label class="flex items-center space-x-1">
                                                <input type="radio" wire:model="past_medical_history.Hepatitis" value="B" class="text-blue-600 border-gray-300 focus:ring-blue-500">
                                                <span>B</span>
                                            </label>
                                            <label class="flex items-center space-x-1">
                                                <input type="radio" wire:model="past_medical_history.Hepatitis" value="C" class="text-blue-600 border-gray-300 focus:ring-blue-500">
                                                <span>C</span>
                                            </label>
                                            <label class="flex items-center space-x-1">
                                                <input type="radio" wire:model="past_medical_history.Hepatitis" value="D" class="text-blue-600 border-gray-300 focus:ring-blue-500">
                                                <span>D</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif ($substep === 2)
                            <div>
                                <h3 class="text-lg font-semibold text-blue-700 mb-3">Family History</h3>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <!-- Column 1 -->
                                    <div class="space-y-2">
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" wire:model.defer="family_history.Bronchial Asthma" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span>Bronchial Asthma</span>
                                        </label>
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" wire:model.defer="family_history.Diabetes Mellitus" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span>Diabetes Mellitus</span>
                                        </label>
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" wire:model.defer="family_history.Thyroid Disorder" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span>Thyroid Disorder</span>
                                        </label>
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" wire:model.defer="family_history.Cancer" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span>Cancer</span>
                                        </label>
                                    </div>

                                    <!-- Column 2 -->
                                    <div class="space-y-2">
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" wire:model.defer="family_history.Hypertension" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span>Hypertension</span>
                                        </label>
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" wire:model.defer="family_history.Liver Disease" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span>Liver Disease</span>
                                        </label>
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" wire:model.defer="family_history.Epilepsy" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span>Epilepsy</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @elseif ($substep === 3)
                            <div>
                                <div class="flex flex-col gap-4 text-sm">
                                    <h3 class="text-lg font-semibold text-blue-700">Personal History</h3>
                                    <label class="flex items-center space-x-2">
                                        <span>Stick/s per day: </span>
                                        <input 
                                            type="number" 
                                            wire:model.defer="personal_history.sticks_per_day"
                                            class="text-gray-700 text-sm ml-2 w-20 border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                            placeholder="N/A">
                                        <span>Pack/s per year: </span>
                                        <input 
                                            type="number" 
                                            wire:model.defer="personal_history.packs_per_year"
                                            class="text-gray-700 text-sm ml-2 w-20 border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                            placeholder="N/A">
                                    </label>
                                    <label class="flex items-center space-x-2">
                                        <span>Alcohol Consumption</span>
                                        <select wire:model="personal_history.Alcohol" class="text-gray-700 text-sm ml-2 w-50 border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <option value="N/A">N/A</option>
                                            @for ($i = 1; $i <= 20; $i++)
                                                <option value="{{ $i }}">{{ $i }} bottle(s) per week</option>
                                            @endfor
                                        </select>
                                    </label>
                                    <label class="flex items-center space-x-2">
                                        <input 
                                            type="checkbox" 
                                            wire:model.defer="personal_history.Vape"
                                            class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <span>Vape</span>
                                    </label>
                                </div>
                            </div>
                        @elseif ($substep === 4)
                            <div>
                                <h3 class="text-lg font-semibold text-blue-700 mb-3">OB-Gyne History</h3>
                                <div class="flex gap-4 text-sm">
                                    <label class="flex flex-col">
                                        <span>LNMP</span>
                                        <input 
                                            type="date" 
                                            wire:model.defer="obgyne_history.LNMP"
                                            class="text-gray-700 text-sm w-40 border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </label>

                                    <label class="flex flex-col">
                                        <span>OB Score</span>
                                        <input 
                                            type="text" 
                                            wire:model.defer="obgyne_history.OB Score"
                                            class="text-gray-700 text-sm w-40 border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                            placeholder="N/A">
                                    </label>

                                    <label class="flex flex-col">
                                        <span>Date of Last Delivery</span>
                                        <input 
                                            type="date" 
                                            wire:model.defer="obgyne_history.Date of Last Delivery"
                                            class="text-gray-700 text-sm w-40 border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </label>
                                </div>
                            </div>
                        @elseif ($substep === 5)
                            <div wire:key="hospitalization-section">
                                <h3 class="text-lg font-semibold text-blue-700 mb-3">Hospitalization History</h3>
                                <textarea rows="2"
                                    wire:model.defer="hospitalization"
                                    class="text-gray-700 text-sm w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    placeholder="Please specify..."></textarea>
                            </div>
                        @elseif ($substep === 6)
                            <div wire:key="operation-section">
                                <h3 class="text-lg font-semibold text-blue-700 mb-3">Operation History</h3>
                                <textarea rows="2"
                                    wire:model.defer="operation"
                                    class="text-gray-700 text-sm w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    placeholder="Please specify..."></textarea>
                            </div>
                        @elseif ($substep === 7)
                            <div>
                                <h3 class="text-lg font-semibold text-blue-700 mb-3">Immunizations History</h3>

                                <div class="grid grid-cols-2 gap-4 text-sm pb-3">
                                    <div class="space-y-2">
                                        <label class="flex items-center space-x-2">
                                            <span>COVID-19 1st</span>
                                            <input type="date" wire:model.defer="immunizations.COVID-19 1st"
                                                class="text-gray-700 text-sm ml-2 w-40 border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        </label>
                                        <label class="flex items-center space-x-2">
                                            <span>COVID-19 2nd</span>
                                            <input type="date" wire:model.defer="immunizations.COVID-19 2nd"
                                                class="text-gray-700 text-sm ml-2 w-40 border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        </label>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="flex items-center space-x-2">
                                            <span>Booster 1</span>
                                            <input type="date" wire:model.defer="immunizations.Booster 1"
                                                class="text-gray-700 text-sm ml-2 w-40 border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        </label>
                                        <label class="flex items-center space-x-2">
                                            <span>Booster 2</span>
                                            <input type="date" wire:model.defer="immunizations.Booster 2"
                                                class="text-gray-700 text-sm ml-2 w-40 border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        </label>
                                    </div>
                                </div>

                                <div class="gap-4 text-sm space-y-2">
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" wire:model.defer="immunizations.Hepa B"
                                            class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <span>Hepa B</span>
                                    </label>
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" wire:model.defer="immunizations.HPV"
                                            class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <span>HPV</span>
                                    </label>
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" wire:model.defer="immunizations.FLU VAC"
                                            class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <span>Flu Vac</span>
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @elseif ($step === 3)
                <div>
                    <h2 class="text-lg font-semibold mb-4 text-blue-700">Physical Examination</h2>
                    <div class="grid grid-cols-8 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Weight <span class="text-red-500">*</span></label>
                            <input type="number" wire:model.live="weight" class="text-gray-800 text-sm mt-1 w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="kg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Height <span class="text-red-500">*</span></label>
                            <input type="number" wire:model.live="height" class="text-gray-800 text-sm mt-1 w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="cm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">BP <span class="text-red-500">*</span></label>
                            <input type="number" wire:model="blood_pressure" class="text-gray-800 text-sm mt-1 w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="mmHg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">HR <span class="text-red-500">*</span></label>
                            <input type="number" wire:model="heart_rate" class="text-gray-800 text-sm mt-1 w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">RR <span class="text-red-500">*</span></label>
                            <input type="number" wire:model="respiratory_rate" class="text-gray-800 text-sm mt-1 w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Temp <span class="text-red-500">*</span></label>
                            <input type="number" wire:model="temperature" class="text-gray-800 text-sm mt-1 w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="°C">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">BMI</label>
                            <input type="number" wire:model="bmi" class="text-gray-800 text-sm mt-1 w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">O2Sat <span class="text-red-500">*</span></label>
                            <input type="number" wire:model="o2sat" class="text-gray-800 text-sm mt-1 w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="%">
                        </div>
                    </div>
                    @if ($errors->any())
                        @php
                            $requiredFields = [
                                'weight' => 'Weight',
                                'height' => 'Height',
                                'blood_pressure' => 'BP',
                                'heart_rate' => 'HR',
                                'respiratory_rate' => 'RR',
                                'temperature' => 'Temp',
                                'o2sat' => 'O2Sat',
                            ];

                            $missingFields = collect($requiredFields)
                                ->filter(fn($label, $field) => $errors->has($field))
                                ->values()
                                ->implode(', ');
                        @endphp

                        @if ($missingFields)
                            <div class="text-red-600 text-sm mb-2">
                                {{ $missingFields }} {{ Str::contains($missingFields, ',') ? 'are' : 'is' }} required.
                            </div>
                        @endif
                    @endif
                    @error('physical_examinations')
                        <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                    @enderror
                    <div class="flex justify-center mb-6">
                        <table class="table-auto w-[80%] border-collapse border border-gray-300 text-sm">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-4 py-1">Section</th>
                                    <th class="border px-4 py-1">Normal <span class="text-red-500 italic text-xs">*</span></th>
                                    <th class="border px-4 py-1">Findings <span class="text-red-500 italic text-xs">*</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sections as $key => $section)
                                    <tr>
                                        <td class="border px-4 py-1">{{ $section }}</td>
                                        <td class="border px-4 py-1 text-center">
                                            <input type="checkbox" wire:model="physical_examinations.{{ $section }}.normal" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="border px-4 py-1">
                                            <input type="text" wire:model="physical_examinations.{{ $section }}.findings"
                                                class="text-gray-800 text-sm w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                wire:keydown.enter.prevent>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif ($step === 4)
                <div>
                    <h2 class="text-lg font-semibold mb-4 text-blue-700">Diagnosis</h2>
                    @foreach ($diagnoses as $index => $diag)
                        <div class="mb-6 flex flex-row gap-4 items-start">
                            <!-- Diagnosis Dropdown -->
                            <div class="w-1/3">
                                <label class="block text-sm font-medium">Diagnosis</label>
                                <select wire:model.defer="diagnoses.{{ $index }}.diagnosis"
                                        class="text-gray-800 text-sm w-full p-2 border border-gray-300 rounded-md">
                                    <option value="">-- Select Diagnosis --</option>
                                    @foreach ($diagnosisOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Notes -->
                            <div class="w-2/3">
                                <label class="block text-sm font-medium">Diagnosis Notes:</label>
                                <textarea wire:model.defer="diagnoses.{{ $index }}.notes"
                                    class="text-gray-800 text-sm w-full border border-gray-300 p-2 rounded"
                                    placeholder="Additional notes..."></textarea>
                            </div>

                            <!-- Remove -->
                            <button type="button" class="text-red-500" wire:click="removeDiagnosis({{ $index }})">✕</button>
                        </div>
                    @endforeach


                    <!-- Add Diagnosis Button -->
                    @if(count($diagnoses) < 5)
                        <div class="mt-2">
                            <button type="button" wire:click="addDiagnosis"
                                class="px-3 py-1 bg-light-blue-1 text-white text-sm rounded-md">
                                + Add Diagnosis
                            </button>
                        </div>
                    @endif

                    <datalist id="diagnosisOptions">
                        @foreach ($diagnosisOptions as $option)
                            <option value="{{ $option }}">
                        @endforeach
                    </datalist>
                </div>
            @elseif ($step === 5)
                <div>
                    <h2 class="text-lg font-semibold mb-4 text-blue-700">Prescription</h2>
                    <textarea rows="2" wire:model.defer="prescription" class="text-gray-800 text-sm w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Enter prescription notes or instructions..."></textarea>
                </div>
            @endif
        </form>
    </div>
</div>