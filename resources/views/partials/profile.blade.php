<div class="card" style="width: 18rem;">
    <div id="profile-avatar" onclick="uploadProfile(this)"></div>
    <div class="card-body">
        <a href="#" class="btn btn-outline-danger"> Delete my account</a>
    </div>
</div>

<div style="display: none;">
    <form action="/user/profile" id="profile" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" id="image" accept="image/png,image/jpeg">
        <button type="submit"></button>
    </form>
</div>

<div class="modal fade" id="confirmModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-submit>Upload</button>
            </div>
        </div>
    </div>
</div>

<script>
    function uploadProfile(profile) {
        let reader;
        let profileData = document.querySelector('#profile');

        profileData.image.addEventListener('change', () => {
            let images = profileData.image.files;

            if (images.length > 0) {
                reader = new FileReader;

                reader.addEventListener('load', () => {
                    let previous = profile.style.backgroundImage;
                    let confirmModal = $('#confirmModal');
                    let cancelBtn = document.querySelector('#confirmModal button[data-dismiss]');
                    let submitBtn = document.querySelector('#confirmModal button[data-submit]');

                    profile.style.backgroundImage = 'url(' + reader.result + ')';

                    cancelBtn.addEventListener('click', () => {
                        profile.style.backgroundImage = previous;
                    });

                    submitBtn.addEventListener('click', () => {
                        profileData.submit();
                    });

                    confirmModal.modal('show');
                });

                reader.readAsDataURL(images[0]);
            }
        });

        profileData.image.click();
    }

</script>
