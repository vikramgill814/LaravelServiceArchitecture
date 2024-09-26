@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Loan EMI Calculation</h1>
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('process.data') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Process Data</button>
        </form>

        <hr>

        @if(empty($emiDetails))
            <p>No EMI data available. Click "Process Data" to generate EMI details.</p>
        @else
            <h2>EMI Details</h2>
            <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="bg-primary text-light">
                        <th>Client ID</th>
                        @if(isset($emiDetails[0]))
                            @foreach($emiDetails[0] as $column => $value)
                                @if($column != 'clientid')
                                    <th>{{ str_replace("_"," ",$column) }}</th>
                                @endif
                            @endforeach
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($emiDetails as $emi)
                    @php $emi=(object) $emi; @endphp
                        <tr>
                            <td>{{ $emi->clientid }}</td>
                            @foreach($emi as $column => $value)
                                @if($column != 'clientid')
                                    <td class="{{$value ? 'text-success' : 'text-danger'}}">{{ $value ?? "0.00" }}</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
@endsection
