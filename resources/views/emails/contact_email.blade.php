<body style="padding: 10px">
<h1>Hello Admin</h1>
<br/>
<h3>You received an email from : {{ $details['name'] }}</h2>
    <br/>
    <h4>Here are the details:</h2>
        <br/>

        <p style="color: #444; margin: 10px 0px">
            <b>Name:</b> {{ $details['name'] }}
            <br/>
            <b>Email:</b> {{ $details['email'] }}
            <br/>
            <b>Subject:</b> {{ $details['subject'] }}
            <br/>
            <b>Message:</b> {{ $details['message'] }}
            <br/>
            <br/>
        </p>


        <h6><b>kind regards</b></h6>

</body>
