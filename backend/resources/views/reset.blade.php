{{-- Click <a href="http://127.0.0.1:5173/reset/{{$token}}">here</a> to reset your Password. --}}


<h1>We have received your request to reset your account password</h1>
<p>You can use the following code to recover your account:</p>


Pincode: {{ $token }}

<a href="http://localhost:3000/reset/{{$token}}">Click Here to change your password </a>



<p>The allowed duration of the code is one hour from the time the message was sent</p>
