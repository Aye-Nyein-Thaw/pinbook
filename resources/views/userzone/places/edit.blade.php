<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit the place {{ $place->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xs sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('userzone.places.update', $place->id) }}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="space-y-4">
                            <x-form-select name="trip_id" label="Trip" :options="$tripOptions" :value="$place->trip_id" placeholder="Choose a trip" required/>

                            <x-form-textinput name="name" label="Name" placeholder="Name of the place" :value="$place->name" required/>

                            <x-form-textarea name="story" label="Story" placeholder="What happened here?" rows="6" :value="$place->story" required/>

                            <div class="grid grid-cols-2 gap-4">
                                <x-form-textinput name="latitude" label="Latitude" placeholder="e.g. 41.3874" :value="$place->latitude" required/>
                                <x-form-textinput name="longitude" label="Longitude" placeholder="e.g. 2.1686" :value="$place->longitude" required/>
                            </div>

                            <x-form-dateinput name="visited_on" label="Visited on" :value="$place->visited_on" required/>

                            <div>
                                <p class="mb-1 text-xs font-semibold">Current photo</p>
                                <img src="{{ $place->getPhotoUrl('thumbnail') }}" alt="{{ $place->name }}" class="w-48 rounded-md">
                            </div>

                            <x-form-fileinput name="photo" label="Replace the photo (optional, jpg or png, max 10 MB)"/>

                            <x-form-multiselect name="categories" label="Categories (hold Ctrl or Cmd to choose several)" :options="$categoryOptions" :value="$place->categories->pluck('id')->all()"/>
                        </div>

                        <hr class="my-4"/>

                        <button type="submit" class="p-2 bg-teal-600 text-white rounded-md hover:bg-teal-700">Update place</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
