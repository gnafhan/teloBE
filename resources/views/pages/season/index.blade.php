<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Dashboard actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Dashboard</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <!-- Add view button -->
                <a href="{{route('seasons.create')}}" class="btn cursor-pointer bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                    <svg class="fill-current shrink-0 xs:hidden" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="max-xs:sr-only">Add Season</span>
                </a>

            </div>

        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Title</th>
                    <th scope="col" class="px-6 py-3">City</th>
                    <th scope="col" class="px-6 py-3">Province</th>
                    <th scope="col" class="px-6 py-3">description</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($seasons as $season)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $season->title }}
                        </th>
                        <td class="px-6 py-4">{{ $season->city }}</td>
                        <td class="px-6 py-4">{{ $season->province }}</td>
                        <td class="px-6 py-4 line-clamp-1">{{ $season->description }}</td>
                        <td class="px-6 py-4">
                            <a href="{{route('seasons.edit', $season)}}" class="text-blue-600 ml-2">Edit</a>
                            <button data-id="{{ $season->id }}" class="text-red-600 hover:underline delete-button">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div id="delete-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
                <h3 class="text-lg font-medium text-gray-900">Are you sure you want to delete this season?</h3>
                <div class="flex justify-end mt-4">
                    <button id="cancel-delete" class="text-gray-600 hover:bg-gray-200 px-4 py-2 rounded">Cancel</button>
                    <form id="delete-form" method="POST" class="inline-block ml-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:bg-red-200 px-4 py-2 rounded">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('.delete-button');
        const modal = document.getElementById('delete-modal');
        const deleteForm = document.getElementById('delete-form');
        const cancelDelete = document.getElementById('cancel-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const id = button.getAttribute('data-id');
                const action = "{{route('seasons.destroy', $season)}}";

                // Set the form action
                deleteForm.setAttribute('action', action);

                // Show the modal
                modal.classList.remove('hidden');
            });
        });

        cancelDelete.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    });
</script>
