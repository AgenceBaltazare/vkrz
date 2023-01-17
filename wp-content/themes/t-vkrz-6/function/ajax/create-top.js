const createTopDoc        = document.querySelector('.create-top-page');
const tabs                = createTopDoc.querySelectorAll('.tabs');
const soumettreTop        = createTopDoc.querySelector('.soumettre-top');
const soumettreContenders = createTopDoc.querySelector('.soumettre-contenders');
const steps               = createTopDoc.querySelectorAll('.step');
const alert               = createTopDoc.querySelector('.alert');
const topFormWrapper      = createTopDoc.querySelector('.top-form-wrapper');
const topTitle            = topFormWrapper.querySelector('#top-title');
const topCategory         = topFormWrapper.querySelector('#top-category');
const topQuestion         = topFormWrapper.querySelector('#top-question');
const topDescription      = topFormWrapper.querySelector('#top-description');
const topImage            = topFormWrapper.querySelector('#top-image');
let tabIndex = 0;

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

soumettreTop.addEventListener('click', function(e) {
  if(
    !topTitle.value || !topCategory.value ||
    !topQuestion.value || !topDescription.value ||
    !topImage.value 
    ) {
    alert.classList.remove('d-none')
  } else {
    showTab("next");

    alert.classList.add('d-none');
    steps[0].classList.add('active');
    steps[1].classList.remove('disable');

    soumettreTop.remove();

    // PROCESS TO RENAME THE IMAGE
    let imgType = topImage.files[0].name.split('.').pop().toLowerCase();
    let element = topImage;
    let file = element.files[0];
    let blob = file.slice(0, file.size, `image/${imgType}`);
    let newImgFileName = new File([blob], `${topTitle.value}.${imgType}`, {
      type: `image/${imgType}`
    });

    let formData = new FormData();
    formData.append('topImage', newImgFileName);
    formData.append('topTitle', topTitle.value);
    formData.append('topCategory', topCategory.value);
    formData.append('topQuestion', topQuestion.value);
    formData.append('topDescription', topDescription.value);

    $.ajax({
      url: "http://localhost:8888/vkrz/wp-json/vkrz/v1/addtop",
      method: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function(data) {
        document.querySelector('.create-top-form').dataset.idtop = data;
      }
    })
  }
});

steps.forEach(step => {
  step.addEventListener('click', function(e) {
    showTab(step.dataset.tabindex);
  })
});

function uploadFile(target) {
  target.parentElement.dataset.text = target.files[0].name;
  var output = document.getElementById('output');
  output.src = URL.createObjectURL(target.files[0]);
  output.onload = function() {
    URL.revokeObjectURL(output.src)
  }
}

function uploadFiles(target) {
  const images = document.querySelector('.images');

  let text = "";
  for (const image in target.files) {
    if(target.files[image].name && target.files[image].type) {
      text += target.files[image].name + ", ";

      images.insertAdjacentHTML('beforeend', `
        <div class="d-flex justify-content-between align-items-center" >
          <img id="outputo-${target.files[image].name}" width="150" height="100" style="margin: 1.1rem 1rem;" />
          <input type="text" class="imageName" value="${(target.files[image].name).split('.')[0]}" />
        </div>
      `)

      var outputo = document.getElementById(`outputo-${target.files[image].name}`);
      outputo.src = URL.createObjectURL(target.files[image]);
      outputo.onload = function() {
        URL.revokeObjectURL(outputo.src)
      }
    }
  }
  target.parentElement.dataset.text = `${(target.files).length} Contenders`;

  soumettreContenders.addEventListener('click', function() {
    const imagesNames = document.querySelectorAll('.imageName');

    showTab("next");

    soumettreContenders.remove();

    steps[1].classList.add('active');
    steps[2].classList.remove('disable');
    steps[2].classList.add('activefinal');

    imagesNames.forEach((imageInput, index) => {

      let formData = new FormData();
      formData.append('contenderPhoto', target.files[index]);
      formData.append('contenderTitle', imageInput.value);
      formData.append('idTop', document.querySelector('.create-top-form').dataset.idtop);

      $.ajax({
        url: "http://localhost:8888/vkrz/wp-json/vkrz/v1/addcontender2",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
          console.log(data);
        }
      })
    })

    // console.log(target.files);
  })
}