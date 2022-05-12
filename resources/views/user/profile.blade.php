@extends('layouts.app')

@section('title', "User - $user->name")

@section('content')
    <div class="row bg-dark-1 p-4 mb-4">
        <div class="col-md-3 px-5">
            <img src="{{ asset($user->profile_image) }}" alt="profile image" class="img-fluid profile-img">
        </div>
        <div class="col-md-9">
            <div>Name: {{ $user->name }}</div>
            <div>Joined: {{ $user->created_at->format('Y-m-d H:i') }}</div>
            @if (Auth::id() == $user->id)
                <a href="{{ route('user.edit') }}" class="text-light">Edit Profile</a>
            @endif
            @can('create', [\App\Models\Invite::class, $user])
                <div class="my-3">
                    @if (is_null($invite))
                        <form action="{{ route('invite.create', $user->id) }}" method="post">
                            @csrf
                            <button class="btn {{ is_null($invite) ? 'btn-primary' : 'btn-secondary' }}" {{ is_null($invite) ? '' : 'disabled' }} type="submit">Invite to Scanlator</button>
                        </form>
                    @else
                        @can('cancel', $invite)
                            <form action="{{ route('invite.cancel', $invite->id) }}" method="post">
                                @method('delete')
                                @if (is_null($invite->response))
                                    @csrf
                                    <button class="btn btn-danger" type="submit">Cancel Invite</button>
                                @else
                                    <button class="btn btn-secondary" disabled type="submit">This User Refused The Invite</button>
                                @endif
                            </form>
                        @endcan
                    @endif
                </div>
            @endcan
        </div>
    </div>
    <div class="row bg-dark-1 px-4 pb-4 pt-3 mb-4">
        <div class="text-center">
            Recent Favorites
            <hr>
        </div>
        <div class="d-flex justify-content-around flex-wrap">
            {{-- @foreach ($mangas_new as $id => $cover)
                @include('_partials.manga_block')
            @endforeach --}}
        </div>
    </div>
    <div class="row bg-dark-1 px-4 pb-4 pt-3 mb-4">
        <div class="text-center">
            Recent Comments
            <hr>
        </div>
        @if (empty($user->comments->first()))
            <div class="text-center h5 mt-3">
                This user does not have any comment.
            </div>
        @else
            @foreach ($user->comments as $key => $comment)
                @if ($key != 0)
                    <hr>
                @endif
                @include('_partials.comment')
            @endforeach
        @endif
    </div>
@endsection