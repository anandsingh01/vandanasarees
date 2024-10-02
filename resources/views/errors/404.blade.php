@extends('layouts.web')

@section('title', __('Not Found'))
@section('css')
    <style>
        .sticky_header {
            position: unset;
            z-index: 9999;
        }
        .watch_header + main {
            margin-top: 0px;
        }

    </style>
<style>
.maincontainer{
    padding:2em
}
.error_section{
    background: #f7f7f7;
}
</style>
@stop
@section('body')
    <section class="error_section sec_ptb_140 clearfix">
        <div class="container">
            <div class="error_content text-center">
                <h2 class="error_text d-flex align-items-center justify-content-center">4 <span>0</span> 4</h2>
                <h3>PAGE NOT FOUND</h3>
                <p>THE PAGE YOU ARE LOOKING FOR DOES NOT EXIST</p>
                <a class="goback_home" href="{{url('/')}}">PLEASE RETURN TO HOME PAGE</a>
            </div>
        </div>
    </section>


@stop
@section('message', __('Not Found'))
