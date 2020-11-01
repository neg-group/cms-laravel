<div class="card" style="width: 18rem;">
    <div class="profile-avatar"></div>
    <div class="card-body">
        <a href="#" class="btn btn-outline-secondary" onclick="uploadProfile()">Upload new
            avatar</a>
        <a href="#" class="btn btn-outline-danger">Delete my account</a>
    </div>
</div>

<div style="display: none;">
    <form action="/user/profile" onsubmit="submitProfile()" id="profile-data" method="POST"
        accept="application/www-urlencoded">
        @csrf
        <input type="hidden" name="profile" value="">
        <input type="file" name="image" accept="image/*">
        <button type="submit"></button>
    </form>
</div>

<script>
    function uploadProfile() {
        let btn, reader, avatar, profile, input;

        btn = event.target;

        reader = new FileReader;
        avatar = document.querySelector('.profile-avatar');
        profile = document.querySelector('#profile-data');
        input = profile.image;

        btn.onclick = null;
        btn.classList.add('disabled');

        reader.addEventListener('load', () => {
            avatar.style.backgroundImage = `url(${reader.result})`;
        });

        reader.addEventListener('loadend', () => {
            let data = reader.result;
            input.type = 'text';
            input.value = data;
            btn.innerText = 'Submit';
            btn.classList.remove('disabled');
            btn.onclick = () => profile.submit();
        })

        input.addEventListener('change', async () => {
            reader.readAsDataURL(input.files[0]);
        });

        input.click();
    }

    function submitProfile() {
        let profile;
        event.preventDefault();
        profile = event.target;
        console.log(profile);
    }

</script>
