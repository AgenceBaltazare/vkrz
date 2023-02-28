import {
  getStorage,
  ref,
  uploadBytesResumable,
  getDownloadURL,
  generateUniqueId,
  fetchDataFuncHelper
} from './config.js';

const createTopDoc        = document.querySelector('.create-top-page');
const tabs                = createTopDoc.querySelectorAll('.tabs');
const soumettreTop        = createTopDoc.querySelector('.soumettre-top');
const soumettreContenders = createTopDoc.querySelector('.soumettre-contenders');
const steps               = createTopDoc.querySelectorAll('.step');
const alertMsg            = createTopDoc.querySelector('.alert');
const topFormWrapper      = createTopDoc.querySelector('.top-form-wrapper');
const topForm             = createTopDoc.querySelector('.create-top-form');
const topTitle            = topFormWrapper.querySelector('#top-title');
const topCategory         = topFormWrapper.querySelector('#top-category');
const topQuestion         = topFormWrapper.querySelector('#top-question');
const topDescription      = topFormWrapper.querySelector('#top-description');
const topImage            = topFormWrapper.querySelector('#top-image');
const topBannerWrapper    = topFormWrapper.querySelector('.top-banner-wrapper');
const contenderImgInput   = createTopDoc.querySelector('.contender-image-input');
const cropperOptionsBtns  = createTopDoc.querySelectorAll('#cropper-options-btn');
let tabIndex = 0;

// DEAL TABS
const showTab = function(direction) {
if(direction === "next") {
  +tabIndex++;
} else if (direction === "prev") {
  if(tabIndex == 0) return;
  +tabIndex--;
} else {
  tabIndex = +direction;
}

tabs.forEach((tab, index) => {
  tab.classList.add('hidden');
  tab.classList.remove('show');
})
tabs[tabIndex].classList.add('show');
tabs[tabIndex].classList.remove('hidden');
}
steps.forEach(step => {
step.addEventListener('click', function(e) {
    showTab(step.dataset.tabindex);
  })
});

let contenders = [];
const uniqueFolderId = generateUniqueId();
document.addEventListener('change', function(e) {

  const contendersDimensionsChecked     = document.querySelector('input[name="contenders-dimension"]:checked');   
  const contenderdimensionsRadioInputs  = document.querySelectorAll('input[name="contenders-dimension"]'); 

  if(e.target !== topImage && e.target !== contenderImgInput && e.target !== contendersDimensionsChecked) return;

  // ALL
  const modal                             = $('#modal'); 
  const files                             = e.target.files;
  const image                             = document.getElementById("image-output");
  const modalRight                        = document.getElementById("modal-right");
  const modalLeft                         = document.getElementById("modal-left");
  const cropAndSendBtn                    = document.querySelector('#cropAndSendBtn');
  const cancelSendBtn                     = document.querySelector('#cancelSendBtn');
  const contenderNameInput                = document.querySelector('#contender-name');
  const contendersImgsWrapper             = document.querySelector('.contenders-images');
  const contendersUploadWrapper           = document.querySelector('.contender-image-upload-wrapper');
  let   cropperBannerTop, canvasBannerTop = null;
  let   cropperContender, canvasContender = null;
  let   isTopToSend, isContenderToSend    = false;
  let   dimensions = { width: null, height: null }
  let   imageName;

  const imageProcess = function(imageOutput) {
    const done = function (url) {
      imageOutput.src = url;
      modal.modal("show");
    };

    if (files && files.length > 0) {
      let file = files[0];
  
      if (URL) {
        done(URL.createObjectURL(file));
      } else if (FileReader) {
        reader = new FileReader();
        reader.onload = function (e) {
          done(reader.result);
        };
        reader.readAsDataURL(file);
      }
    } else return;
  }

  const reset = function() {
    
    if(cropperContender) {
      cropperContender.destroy(true);
      cropperContender.setCropBoxData({ width: 0, height: 0 });
      cropperContender.setData({ x: 0, y: 0, width: 0, height: 0, rotate: 0 });
      cropperContender = null;
    }

    if(cropperBannerTop) {
      cropperBannerTop.destroy(true);
      cropperBannerTop.setCropBoxData({ width: 0, height: 0 });
      cropperBannerTop.setData({ x: 0, y: 0, width: 0, height: 0, rotate: 0 });
      cropperBannerTop = null;
    }

    if(contenderNameInput) {
      contenderNameInput.value = "";
    }

    isTopToSend = false;
    isContenderToSend = false;
    
  }

  const initCropper = function(cropper, image, dimensions) {
    cropper = new Cropper(image, {
      dragMode: "move",
      autoCropArea: 1,
      restore: false,
      guides: false,
      center: false,
      dragCrop: true, 
      multiple: true, 
      movable: true,
      highlight: false,
      cropBoxMovable: true,
      cropBoxResizable: false,
      toggleDragModeOnDblclick: false,
      modal: true,
      preview: ".preview",

      ready: function () {
        cropper.setCropBoxData({
            width: dimensions.width,
            height: dimensions.height,
        });
      },          
    });

    return cropper;
  }

  // TOP
  if (e.target === topImage) 
  {
    isTopToSend = true;

    imageProcess(image)

    dimensions.width = 1200;
    dimensions.height = 630;

    image.width = dimensions.width
    image.height = dimensions.height

    imageName = topTitle.value ? topTitle.value : "";
  } 
  // CONTENDER
  else if (contendersDimensionsChecked || e.target === contenderImgInput) {
    isContenderToSend = true;
        
    if(contendersDimensionsChecked !== null) {   
      contendersUploadWrapper.classList.remove('d-none');

      if(contendersDimensionsChecked.value === "vertical") {
        dimensions.width = 400;
        dimensions.height = 600
  
        image.width = dimensions.width
        image.height = dimensions.height
      } else if (contendersDimensionsChecked.value === "carre") {
        dimensions.width = 400;
        dimensions.height = 400
  
        image.width = dimensions.width
        image.height = dimensions.height
      } else if (contendersDimensionsChecked.value === "paysage") {
        dimensions.width = 600;
        dimensions.height = 400
  
        image.width = dimensions.width
        image.height = dimensions.height
      }
      
      document.querySelector('.contender-group-input').classList.remove('d-none');
      modalLeft.className = "col-md-8"
      modalRight.className = "col-md-4"
      imageProcess(image)
    }
  }

  modal
  .on("shown.bs.modal", function () {

    if (isTopToSend) {
      cropperBannerTop = initCropper(cropperBannerTop, image, dimensions);
    } else if (isContenderToSend) {
      cropperContender = initCropper(cropperContender, image, dimensions);

      contenderNameInput.value = ((contenderImgInput.files[0].name).replace(/\.[^.]*$/,'')).charAt(0).toUpperCase() + (contenderImgInput.files[0].name).replace(/\.[^.]*$/,'').slice(1);

      contenderNameInput.focus();
    }

    const cropImage = function(cropper, canvas, imageName, type) {

      if(type === "contender") 
        imageName = contenderNameInput.value;

      // PREVENT DUPLICATES FOR CONTENDERS
      if(type === "contender" && contenders.some(contender => contender.contenderName === imageName)) {
        alert("T'as déjà envoyé ce contender ;)");

        return;
      } 

      canvas = cropper.getCroppedCanvas({
        width: dimensions.width,
        height: dimensions.height,
      });

      if(!canvas) return;

      const storage    = getStorage();
      const storageRef = ref(storage, `${topTitle.value}-${uniqueFolderId}/${imageName}-${generateUniqueId()}`);
    
      canvas.toBlob(function (blob) {
        const uploadTask = uploadBytesResumable(storageRef, blob);
    
        uploadTask.on(
          "state_changed",
          (snapshot) => {
            const progress =
              (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
            // console.log("Upload is " + progress + "% done");
            switch (snapshot.state) {
              case "paused":
                // console.log("Upload is paused");
                break;
              case "running":
                // console.log("Upload is running");
                break;
            }
          },
          (error) => {},
          () => {
            getDownloadURL(uploadTask.snapshot.ref).then((downloadURL) => {

              if(!alertMsg.classList.contains('d-none'))
              alertMsg.classList.add('d-none');
              modal.modal("hide");
              console.log("File available at", downloadURL);

              if(type === "top") {
                topBannerWrapper.innerHTML = `
                  <div>
                    <img src=${downloadURL} title=${topTitle.value} id="previewTopBanner" width="150" height="100" />

                    <div class="image-sent">
                      <img src="https://img.icons8.com/flat-round/256/checkmark.png" class="checkmark" />
                      <span>Envoyé !</span>
                    </div>
                  </div>
                `;
                isTopToSend = false; // KHLASS C BON
              } else if(type === "contender") {
                contenderdimensionsRadioInputs.forEach(input => {
                  input.disabled = true;
                  input.readOnly = true;
                })

                contendersImgsWrapper.insertAdjacentHTML("beforeend", `
                  <div>
                    <img src=${downloadURL} title=${contenderNameInput.value} width="100" height="100" />

                    <div class="image-sent">
                      <img src="https://img.icons8.com/flat-round/256/checkmark.png" class="checkmark" />
                      <span>Envoyé !</span>
                    </div>
                  </div>
                `);

                contenders.push({ 
                    idTop: topForm.dataset.idtop, 
                    contenderName: contenderNameInput.value, 
                    contenderURL: downloadURL
                });
              }

            });
          }
        );
      }); 

    }

    cropperOptionsBtns.forEach(btn => {
      btn.addEventListener('click', function(e) {
        const option = e.target.closest('#cropper-options-btn').dataset.option;

        switch (option) {
          case 'cropper-zoom-in':
            cropperBannerTop?.zoom(0.1);
            cropperContender?.zoom(0.1);
            break;
          case 'cropper-zoom-out':
            cropperBannerTop?.zoom(-0.1);
            cropperContender?.zoom(-0.1);
            break;
          case 'cropper-move-left':
            cropperBannerTop?.move(-10, 0);
            cropperContender?.move(-10, 0);
            break;
          case 'cropper-move-right':
            cropperBannerTop?.move(10, 0);
            cropperContender?.move(10, 0);
            break;
          case 'cropper-move-up':
            cropperBannerTop?.move(0, -10);
            cropperContender?.move(0, -10);
            break;
          case 'cropper-move-down':
            cropperBannerTop?.move(0, 10);
            cropperContender?.move(0, 10);
            break;
          default:
            console.error(`Error Handling Cropper Options! 📛`);
        }
      });
    })

    cropAndSendBtn.addEventListener("click", function () {

      if(isTopToSend) {

        if(topTitle.value) {
          cropImage(cropperBannerTop, canvasBannerTop, imageName, "top")
        } else {
          alert("Faut remplir tous les champs d'avant s'il te pleeyy!")
        }
      } else if(isContenderToSend) {
        cropImage(cropperContender, canvasContender, imageName, "contender")
      }

    }, { once: true });
    cancelSendBtn.addEventListener("click", reset, { once: true });

  })
  .on("hidden.bs.modal", function () {
    reset();
  });

});

soumettreTop.addEventListener('click', function(e) {
  if(
    !topTitle.value    || !topCategory.value    ||
    !topQuestion.value || !topDescription.value ||
    !topImage.value 
    ) {
      alertMsg.classList.remove('d-none')
  } else {
    topTitle.readOnly       = "true" 
    topCategory.readOnly    = "true" 
    topCategory.disabled    = "true" 
    topQuestion.readOnly    = "true" 
    topDescription.readOnly = "true" 
    topImage.readOnly       = "true" 
    topImage.disabled       = "true" 

    showTab("next");

    alertMsg.classList.add('d-none');
    steps[0].classList.add('active');
    steps[1].classList.remove('disable');

    soumettreTop.remove();

    $.ajax({
      url: "https://vainkeurz.local/wp-json/vkrz/v1/addtop",
      method: "POST",
      data: {
        topTitle: topTitle.value,
        topCategory: topCategory.value,
        topQuestion: topQuestion.value,
        topDescription: topDescription.value,
        topBanner: topBannerWrapper.querySelector("#previewTopBanner").src,
        topAuthor: topForm.dataset.idtopauthor,
      },
      success: function(results) {
        const [createdIdTop, createdTopUrl] = results;
        topForm.dataset.idtop = createdIdTop;
        topForm.dataset.topurl = createdTopUrl;
      }
    })
  }
});

soumettreContenders.addEventListener('click', async (e) => {
  e.preventDefault();
  
  if(!contenderImgInput.value) {
    alertMsg.classList.remove('d-none')
  } else if(contenders.length < 2) {
    alertMsg.innerHTML = `
      <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Essaie de mettre plus de 2 contenders s'il te pleyy! 🤭
    `;
    alertMsg.classList.remove('d-none')
  } else {
    contenderImgInput.readOnly = "true";
    contenderImgInput.disabled = "true";

    showTab("next");

    steps[1].classList.add('active');
    steps[2].classList.remove('disable');
    steps[2].classList.add('activefinal');

    soumettreContenders.remove();

    contenders.forEach(contender => {
      $.ajax({
        url: "https://vainkeurz.local/wp-json/vkrz/v1/addcontenderfromcreatetop",
        method: "POST",
        data: {
          idTop: contender.idTop,
          contenderName: contender.contenderName,
          contenderURL: contender.contenderURL
        },
        success: function(data) {
          // console.log(data);
        }
      })
    })

    let currentUserData = await fetchDataFuncHelper(`http://vainkeurz.local/wp-json/vkrz/v1/getuserinfo/${currentUuid}`);

    console.log(topBannerWrapper.querySelector("#previewTopBanner").src)

    const data = { 
      typeMessage: "newTopCreated",
        data: {
          top: `TOP ${contenders.length} ${topTitle.value}`,
          topQuestion: topQuestion.value,
          topUrl: topForm.dataset.topurl,
          topVisuel: topBannerWrapper.querySelector("#previewTopBanner").src,
          creatorData: currentUserData,
        }
     };
  
    await fetch('http://vainkeurz.local:3002/discord', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
      .then((response) => console.log(response))
      .catch((error) => console.error(error));
  }
})