<h1>
uporabnik najel sobo
</h1>

<h5>uporabnik: </h5>
{{ $emaildata[2] ?? '' }}
<br />
<h5>najem od dne: </h5>
{{ $emaildata[0] ?? '' }}
<br />
<h5>najem do dne: </h5>
{{ $emaildata[1] ?? '' }}
<br />
<h5>stevilo dni: </h5>
{{ $emaildata[3] ?? '' }}
<br />
<h5>soba: </h5>
{{ $emaildata[4] ?? '' }}	
<h5>cena sobe na noc: </h5>
{{ $emaildata[5] ?? '' }}
<br />
<h5>skupaj cena: </h5>
{{ $emaildata[6] ?? '' }}
<br />
