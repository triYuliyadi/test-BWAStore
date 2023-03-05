@extends('layouts.success')

@section('title')
    Store Cart Page
@endsection

@section('content')
<div class="page-content page-success">
  <div class="section-success" data-aos="zoom-in">
    <div class="container">
      <div class="row align-items-center justify-content-center row-login">
        <div class="col-lg-6 text-center">
          <img src="/images/icons/success.svg" alt="Success" class="mb-4" />
          <h2>Transaction Processed!</h2>
          <p>
            Silahkan tunggu konfirmasi email dari kami dan kami akan
            menginformasikan resi secept mungkin!
          </p>
          <div>
            <a href="{{ route('dashboard') }}" class="btn btn-success w-50 mt-4">
              My Dashboard
            </a>
            <a href="{{ route('home') }}" class="btn btn-signup w-50 mt-2">
              Go to Shopping
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection