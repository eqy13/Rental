

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Ubah Password</title>

<link rel="stylesheet"
href="./assets/css/style-settings-admin.css">
</head>

<body>

<div class="main">

<div class="glass-card"
style="max-width:600px;margin:auto;">

<h2>Ubah Password</h2>

<form id="passwordForm">

<div class="form-group">

<label>Password Baru</label>

<input
type="password"
id="password"
required>

</div>

<button
class="primary-btn">

Simpan Password

</button>

</form>

</div>

</div>

<script>

document
.getElementById(
'passwordForm'
)
.addEventListener(
'submit',
async e=>{

e.preventDefault();

const response =
await fetch(
'./api/change-password-admin.php',
{
method:'POST',
headers:{
'Content-Type':
'application/json'
},
body:JSON.stringify({
password:
document.getElementById(
'password'
).value
})
}
);

const result =
await response.json();

if(result.success){

alert(
'Password berhasil diubah'
);

window.location.href=
'settings-admin.php';

}

}
);

</script>

</body>
</html>