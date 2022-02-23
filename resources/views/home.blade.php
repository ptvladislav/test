@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('userNotFound'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('userNotFound') }}
                        </div>
                    @endif
                       @if (session('transferError'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('transferError') }}
                        </div>
                    @endif
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('successPayment'))
                            <div class="alert alert-success" role="alert">
                                {{ session('successPayment') }}
                            </div>
                        @endif
                    @if(session('lowBalance'))
                        <div class="alert alert-warning" role="alert">
                            {!! Session::get('lowBalance') !!}
                        </div>
                        @endif
                        @if(session('deposit'))
                            <div class="alert alert-success" role="alert">
                                {!! Session::get('deposit') !!}
                            </div>
                        @endif
                        @if(session('transfer'))
                            <div class="alert alert-success" role="alert">
                                {!! Session::get('transfer') !!}
                            </div>
                        @endif
                    <div class="row">
                        <div class="col-md-6 info-user">
                            <ul class="detail-u">
                                <li class="balance"><strong>Your balance</strong> - ${{ $balance }}</li>
                                <li><strong>Your nickname</strong> - {{ $nickname }}</li>
                                <li><strong>Your email</strong> - {{ $email }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Deposit Balance</strong>
                                    <form action="{{ route('deposit') }}" method="POST">
                                        @csrf
                                        <input value="{{ \App\Models\Transfer::STATUS_DEPOSIT }}" name="type" hidden>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">$</span>
                                        <input name="amountDep" type="text" class="form-control @error('amountDep') is-invalid @enderror" aria-label="Amount (to the nearest dollar)">
                                        @error('amountDep')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success">Deposit</button>
                                    </form>
                                </div>

                                <div class="col-md-6">
                                    <strong>Transfer</strong>
                                    <form action="{{ route('transfer') }}" method="POST">
                                        @csrf
                                        <input value="{{ \App\Models\Transfer::STATUS_WITHDRAW }}" name="type" hidden>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">@</span>
                                            <input type="text" class="form-control @error('transferUser') is-invalid @enderror" name="transferUser" placeholder="Username or Email" aria-label="Username" aria-describedby="basic-addon1">
                                            @error('transferUser')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input name="amount" type="text" class="form-control @error('amount') is-invalid @enderror" aria-label="Amount (to the nearest dollar)">
                                            @error('amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">Transfer</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Transfer History</div>
                    @if($withdraws)
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Transfer to user</th>
                                <th scope="col">Type</th>
                                <th scope="col">Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($withdraws as $transaction)
                                <tr>

                                    <td>{{ $transaction->id }}</td>
                                    <td>${{ $transaction->amount }} </td>
                                    <td>{{ $transaction->receivedUser->email }} </td>
                                    <td>
                                        @if(\App\Models\Transfer::STATUS_DEPOSIT == $transaction->type)
                                            <span class="badge bg-success"> {{ $transaction->getStatus() }} </td></span>
                                    @else
                                        <span class="badge bg-primary"> {{ $transaction->getStatus() }} </td></span>
                                    @endif
                                    <td>{{ $transaction->created_at->diffForHumans() }} </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Users in System</div>
                    @if($allUsers)
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">NickName</th>
                                <th scope="col">Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($allUsers as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->nickname }} </td>
                                    <td>{{ $user->email }} </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
