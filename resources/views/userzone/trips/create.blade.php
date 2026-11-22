<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create a new trip
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xs sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('userzone.trips.store') }}" method="post">
                        @csrf

                        <div class="space-y-4">
                            <x-form-textinput name="title" label="Title" placeholder="Your trip title" required/>

                            <x-form-textarea name="description" label="Description" placeholder="What is this trip about?" rows="6" required/>

                            <x-form-textinput name="destination" label="Destination" placeholder="Where did you go?" required/>

                            <x-form-dateinput name="start_date" label="Start date" required/>

                            <x-form-dateinput name="end_date" label="End date (optional)"/>

                            <x-form-select name="is_public" label="Visibility" :options="$visibilityOptions" placeholder="Public or private?" required/>
                        </div>

                        <hr class="my-4"/>

                        <button type="submit" class="p-2 bg-teal-600 text-white rounded-md hover:bg-teal-700">Add trip</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
