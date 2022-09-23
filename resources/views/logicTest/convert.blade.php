@extends('layout.template')


@section('header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Convert Number to Text</h1>
        </div>
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection


@section('content')
<h3 class="mb-4">Insert Value</h3>
<form action="{{ route('swap.post') }}" method="post">
   @csrf
   <div class="row">
       <div class="col-3">
           <div class="form-group row">
               <label for="x" class="col-sm-1 col-form-label text-right">A : </label>
               <div class="col-sm-11">
                   <input type="number" class="form-control-plaintext border" id="valueA" value="{{ old('dataA') }}" name="dataA">
               </div>
           </div>
       </div>
       <div class="col-3">
           <div class="form-group row">
               <label for="x" class="col-sm-1 col-form-label text-right">B : </label>
               <div class="col-sm-11">
                   <input type="number" class="form-control-plaintext border" id="valueB" value="{{ old('dataB') }}" name="dataB">
               </div>
           </div>
       </div>
       <div class="col-3">
           <div class="form-group row">
               <button class="btn btn-primary" id="button" type="submit">Swap</button>
           </div>
       </div>
   </div>
</form>

<h4>Result Swap data ( A = {{ $dataB }} | B = {{ $dataA }} )</h4>
<p><strong>A</strong> : {{ $dataA }}</p>
<p><strong>B</strong> : {{ $dataB }}</p>
@endsection
