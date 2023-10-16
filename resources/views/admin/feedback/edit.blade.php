 @extends('admin.layouts.app')
 @section('main')
     @include('admin.layouts.top-nav')

     <div class="container py-12">
         <form action="{{ route('admin.feedback.update') }}" method="POST" class="row g-3 update-form">
             @csrf
             <div class="col-md-12">
                 <label for="inputCity" class="form-label">Title</label>
                 <input type="hidden" name="id" value="{{ $id['id'] }}">
                 <input type="text" name="title" value="{{ $id['title'] }}" required class="form-control"
                     id="inputCity">
             </div>
             <div class="form-floating">
                 <textarea class="form-control" name="description" required placeholder="Leave a comment here" id="floatingTextarea">{{ $id['description'] }}</textarea>
                 <label for="floatingTextarea">Description</label>
             </div>
             <div class="row mt-3">
                 <div class="col-md-6">
                     <label for="formFile" class="form-label">File</label>
                     <input class="form-control" type="file" id="formFile" name="attachments"
                         accept=".png, .jpeg, .jpg">
                     @if ($id['attachments'])
                         <img src="{{ asset('FeedbackImages/' . $id['attachments']) }}" alt="Current Image">
                     @endif
                 </div>
                 @if ($category)
                     <div class="col-md-6">
                         <label for="inputState" class="form-label">Category</label>
                         <select class="form-select form-select-md" name="category" required
                             aria-label=".form-select-lg example">
                             <option selected disabled value="">Select a category</option>
                             @foreach ($category as $val)
                                 <option value="{{ $val['id'] }}"
                                     {{ $val['id'] == $id['category_id'] ? 'selected' : '' }}>{{ $val['name'] }}</option>
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

 @endsection
