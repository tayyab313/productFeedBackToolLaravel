<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Feedback') }}
        </h2>
    </x-slot>

    <div class="container py-12">
        <form action="{{ route('feedback.store') }}" method="POST" class="row g-3 save-form">
            @csrf
            <div class="col-md-12">
                <label for="inputCity" class="form-label">Title</label>
                <input type="text" name="title" required class="form-control" id="inputCity">
              </div>
              <div class="form-floating">
                <textarea class="form-control" name="description" required placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                <label for="floatingTextarea">Description</label>
              </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="formFile" class="form-label">File</label>
                    <input class="form-control" type="file" id="formFile" name="attachments" accept=".png, .jpeg, .jpg">
                </div>
                @if($category)
                <div class="col-md-6">
                <label for="inputState" class="form-label">Category</label>
                <select class="form-select form-select-md" name="category" required aria-label=".form-select-lg example">
                    <option selected disabled value="">Select a category</option>
                    @foreach ($category as $val )
                    <option value="{{$val['id']}}">{{$val['name']}}</option>

                    @endforeach
                </select>
                </div>
                @endif
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
    </div>
</x-app-layout>

