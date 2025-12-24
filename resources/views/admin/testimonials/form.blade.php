@extends('admin.layout')
@section('content')
<h4>{{ $item->exists ? 'Edit' : 'Create' }} Article</h4>
<form method="post" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.articles.update',$item->id) : route('admin.articles.store') }}">@csrf @if($item->exists) @method('PUT') @endif
<input name="title" class="form-control mb-2" value="{{ old('title',$item->title) }}" placeholder="Title">
<input name="excerpt" class="form-control mb-2" value="{{ old('excerpt',$item->excerpt) }}" placeholder="Excerpt">
<textarea name="content" class="form-control mb-2">{{ old('content',$item->content) }}</textarea>
<input type="file" name="image" class="form-control mb-2">
<input name="published_at" class="form-control mb-2" value="{{ old('published_at',$item->published_at) }}" placeholder="Published At">
<button class="btn btn-primary">Save</button></form>
@endsection
