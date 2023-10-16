<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Feedback') }}
        </h2>
    </x-slot>

    <div class="container py-12">
        <div class="col-md-12 mb-3">
            <label for="inputCity" class="form-label">Vote :  </label>
            <div class="input-group">
                <div class="input-group-text">
                    <input class="form-check-input mt-0 mr-4" type="radio" value="1" name="like" id="{{$id['id']}}" {{( $id->isVoteBy(auth()->user()) && $id['votes'][0]['vote']==1)?  'checked':'' }} url="{{route('feedback.voteStatus')}}" class="status_feedback"><span>Like</span>
                    <input class="ml-4 form-check-input mt-0" type="radio" value="0" name="like" id="{{$id['id']}}" {{( $id->isVoteBy(auth()->user()) && $id['votes'][0]['vote']==0)? 'checked':'' }} url="{{route('feedback.voteStatus')}}" class="status_feedback"><span>Dislike</span>
                </div>
              </div>
        </div>


            <div class="col-md-12">
                <label for="inputCity" class="form-label">Vote Count: </label><b><span>{{$id['votes_count']}}</span></b>
              </div>
              <div class="col-md-12">
                <label for="inputCity" class="form-label">Category : </label><b><span>{{$id['category']['name']}}</span></b>

            </div>
            <div class="col-md-12">
                <label for="inputCity" class="form-label">Title : </label><b><span>{{$id['title']}}</span></b>
              </div>
            <div class="col-md-12">
                <label for="inputCity" class="form-label">Description : </label><b><span>{{$id['description']}}</span></b>
              </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="formFile" class="form-label">File : </label>
                    <img style="    width: 50%;" src="{{asset('FeedbackImages/'.$id['attachments'].'')}}">
                </div>
                <div class="col-md-6 mt-1">
                    <h6>FeedBack Item Comments</h6>
                    <div class="post-comments-{{ $id['id'] }}">
                        @if (count($id['comments']))

                            @foreach ($id['comments'] as $key2 => $data)
                                <div class="mt-4 d-flex">
                                    <div class="ms-3 mt-2">
                                        <h6 class="fs-13 mb-0 fw-bold">
                                            {{ $data['user']['name']}} ( {{ date_format($data['created_at'], 'd-M-Y ') }} )
                                        </h5>
                                        {{ $data->content }}
                                    </div>
                                </div>
                            @endforeach
                        @else
                        @endif

                    </div>


                    <!-- Add Commennt Box -->
                    <form class="comment-form">
                        @csrf
                        <div class="comment-box mt-4 d-flex">
                            <div class="w-100">
                                <input type="text" name="comentData"
                                    class="comentData-{{ $id->id }} w-100 px-4" id=""
                                    placeholder="Write Here....">
                            </div>
                            <div>
                                <input type="hidden" id="postid"
                                    name="postid-{{ $id->id }}" value="{{ $id->id }}">
                                    <button type="button" url="{{route('feedback.comment')}}" class="comment-button btn p-0 scale-img"
                                    data-get-id="{{ $id->id }}"><img style="width: 40px"
                                        src="{{ asset('img/comment-btn.svg') }}"
                                        alt=""></button>
                            </div>
                        </div>
                    </form>

                </div>


            </div>
    </div>
</x-app-layout>

