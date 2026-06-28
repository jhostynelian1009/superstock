@extends('layouts.admin')

@section('title', 'Editar categoría')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Editar categoría</h1>
        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Actualiza la información de {{ $category->name }}.</p>
    </div>

    @include('admin.partials.flash')

    <div class="max-w-2xl rounded-lg bg-white p-6 shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:bg-[#161615] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
        <form action="{{ route('admin.categorias.update', $category) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                    Nombre <span class="text-[#F53003]">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                    class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm text-[#1b1b18] focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('name') border-[#F53003] @enderror">
                @error('name')
                    <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="slug" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}"
                    class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm text-[#1b1b18] focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('slug') border-[#F53003] @enderror">
                @error('slug')
                    <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Descripción</label>
                <textarea name="description" id="description" rows="4"
                    class="min-h-[120px] w-full resize-y rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm text-[#1b1b18] focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="rounded-sm bg-[#1b1b18] px-5 py-1.5 text-sm font-medium text-white transition-colors hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white">
                    Actualizar
                </button>
                <a href="{{ route('admin.categorias.index') }}"
                    class="inline-flex items-center rounded-sm border border-[#e3e3e0] px-5 py-1.5 text-sm font-medium text-[#1b1b18] transition-colors hover:bg-[rgba(0,0,0,0.04)] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection
