<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create a new place
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xs sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('userzone.places.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-4">
                            <x-form-select name="trip_id" label="Trip" :options="$tripOptions" placeholder="Choose a trip" required/>

                            <x-form-textinput name="name" label="Name" placeholder="Name of the place" required/>

                            <x-form-textarea name="story" label="Story" placeholder="What happened here?" rows="6" required/>

                            <div class="grid grid-cols-2 gap-4">
                                <x-form-textinput name="latitude" label="Latitude" placeholder="e.g. 41.3874" required/>
                                <x-form-textinput name="longitude" label="Longitude" placeholder="e.g. 2.1686" required/>
                            </div>

                            <x-form-dateinput name="visited_on" label="Visited on" required/>

                            <x-form-fileinput name="photo" label="Photo (optional, jpg or png, max 10 MB)"/>

                            <x-form-multiselect name="categories" label="Categories" placeholder="Choose categories" :options="$categoryOptions"/>
                        </div>

                        <hr class="my-4"/>

                        <button type="submit" class="p-2 bg-teal-600 text-white rounded-md hover:bg-teal-700">Add place</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
