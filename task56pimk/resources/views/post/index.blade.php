@extends('layouts.app', ['title' => 'Data Posts'])

@section('content')
<div class="container mx-auto mt-10 mb-10 px-64">
    <div class="bg-white p-5 rounded shadow-sm">
        <div class="flex justify-between mb-4">
            <div>
                <button id="show-form" class="bg-blue-500 text-white p-3 rounded shadow-sm focus:outline-none hover:bg-blue-600">Insert</button>
            </div>
        </div>

        <!-- Form untuk insert data yang disembunyikan sebagai bagian dari konsep AJAX -->
        <div id="form-container" class="bg-white p-5 rounded shadow-sm mb-4 hidden">
            <form id="post-form" action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mt-2">
                    <label>Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full bg-gray-200 p-2 rounded shadow-sm border border-gray-200 focus:outline-none focus:bg-white mt-2" placeholder="judul post">
                    <div id="error-title" class="bg-red-400 p-2 shadow-sm rounded mt-2 hidden"></div>
                </div>
                <div class="mt-2">
                    <label>Content</label>
                    <input type="text" name="content" value="{{ old('content') }}" class="w-full bg-gray-200 p-2 rounded shadow-sm border border-gray-200 focus:outline-none focus:bg-white mt-2" placeholder="judul post">
                    <div id="error-content" class="bg-red-400 p-2 shadow-sm rounded mt-2 hidden"></div>
                </div>
                <div class="mt-2">
                    <button type="submit" class="bg-blue-500 text-white p-2 rounded shadow-sm focus:outline-none hover:bg-blue-600">SAVE</button>
                </div>
            </form>
        </div>

        <!-- Tabel hasil Insert data -->
        <table class="min-w-full table-auto">
            <thead class="justify-between">
                <tr class="bg-black w-full">
                    <th class="px-16 py-2 text-left"><span class="text-white">Title</span></th>
                    <th class="px-16 py-2 text-left"><span class="text-white">Content</span></th>
                </tr>
            </thead>
            <tbody class="bg-gray-200" id="post-table-body">
                @forelse($posts as $post)
                    <tr class="bg-white border-2 border-gray-200">
                        <td class="px-16 py-2">{{ $post->title }}</td>
                        <td class="px-16 py-2">{!! $post->content !!}</td>
                        </td>
                    </tr>
                @empty
                    <div class="bg-red-500 text-white p-3 rounded shadow-sm mb-3">Data empty</div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-2">{{ $posts->links('vendor.pagination.tailwind') }}</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // fungsi menampilkan form insert
        $('#show-form').click(function() {
            $('#form-container').toggleClass('hidden');
        });

        // Menghindari data diambil secara default, sehingga data dikirim melalui AJAX
        $('#post-form').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: '{{ route("post.store") }}',
                data: formData,
                success: function(response) {
                    toastr.success('Data Berhasil Disimpan!', 'SUCCESS');
                    $('#post-table-body').prepend(`
                        <tr class="bg-white border-2 border-gray-200">
                            <td class="px-16 py-2">${response.title}</td>
                            <td class="px-16 py-2">${response.content}</td>
                        </tr>
                    `);
                    $('#post-form')[0].reset();
                    $('#form-container').addClass('hidden');
                },
                error: function(response) {
                    var errors = response.responseJSON.errors;
                    if (errors.title) {
                        $('#error-title').text(errors.title[0]).removeClass('hidden');
                    } else {
                        $('#error-title').addClass('hidden');
                    }
                    if (errors.content) {
                        $('#error-content').text(errors.content[0]).removeClass('hidden');
                    } else {
                        $('#error-content').addClass('hidden');
                    }
                }
            });
        });
    });
</script>
@endpush
