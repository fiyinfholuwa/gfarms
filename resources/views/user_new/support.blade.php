@extends('user_new.app')

@section('content')
<h1>Support</h1>

<div style="height:80vh; margin-top:30px;">
    <iframe 
        src="https://tawk.to/chat/64a3f86294cf5d49dc617131/1h4g84h8o" 
        width="100%" 
        height="600" 
        style="border:none; border-radius:12px; box-shadow:0 0 10px rgba(0,0,0,0.1);"
        allow="microphone; camera"
    ></iframe>
</div>

<div class="support-line">
    <span><i class="fa fa-phone text-orange me-2"></i> Toll-Free: <strong>0800-123-4567</strong></span>
    <span><i class="fa fa-headset text-orange mx-3"></i> Direct Support</span>
    <span><i class="fa fa-map-marker text-orange ms-3"></i> Ikeja, Lagos</span>
</div>

<style>
.support-line {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 2rem;
    margin-top: 25px;
    background: #fff;
    padding: 1rem 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    color: #333;
    font-weight: 500;
    flex-wrap: wrap;
    margin-top:-70px;
}
.text-orange {
    color: #ff6600;
}
</style>

@endsection

