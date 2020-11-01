<?php
use App\Models\User; ?>
<div class="table-responsive">
    <h2>User</h2>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Emai</th>
                <th scope="col">Status</th>
                <th scope="col">Joined at</th>
            </tr>
        </thead>
        <tbody>
            @foreach (User::all() as $user)
                @if ($user->id == Auth::user()->id)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->email_verified_at)
                                <span class="badge badge-success">Verified</span>
                            @else
                                <span class="badge badge-secodary">Unverified</span>
                            @endif
                        </td>
                        <td> {{ $user->created_at->format('h:iA d/m/Y(D)') }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
