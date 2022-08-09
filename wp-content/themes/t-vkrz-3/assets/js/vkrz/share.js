
// Partage en mode natif DEBUT
const shareClassementNatif = document.querySelector(".share-natif-classement");
const shareTopNatif = document.querySelector(".share-natif-top");
const shareClassement = document.querySelector("#share-classement");
const shareTop = document.querySelector("#share-classement");

if (shareClassementNatif) {
    shareClassementNatif.addEventListener("click", (event) => {
        if (navigator.share && window.matchMedia("(max-width: 1024px)").matches) {
            $(".share-natif-classement").click(function () {
                $(".share-classement-content").removeClass("active-box");
            });
            navigator
                .share({
                    title: "ShareNatif API",
                    url: "",
                })
                .then(() => {
                    console.log("Merci pour le partage !");
                })
                .catch(console.error);
        } else {
            $(".share-natif-classement").click(function () {
                $(".share-classement-content").addClass("active-box");
            });
            $(".close-share").click(function () {
                $(".share-classement-content").removeClass("active-box");
            });
        }
    });
}

shareTopNatif.addEventListener("click", (event) => {
    if (navigator.share && window.matchMedia("(max-width: 1024px)").matches) {
        $(".share-natif-top").click(function () {
            $(".share-top-content").removeClass("active-box");
        });
        navigator
            .share({
                title: "ShareNatif API",
                url: "",
            })
            .then(() => {
                console.log("Merci pour le partage !");
            })
            .catch(console.error);
    } else {
        $(".share-natif-top").click(function () {
            $(".share-top-content").addClass("active-box");
        });
        $(".close-share").click(function () {
            $(".share-top-content").removeClass("active-box");
        });
    }
});
