function changeView() {
  var signUpBox = document.getElementById("signUpBox");
  var signInBox = document.getElementById("signInBox");

  signUpBox.classList.toggle("d-none");
  signInBox.classList.toggle("d-none");
}

function signUp() {
  var firstName = document.getElementById("fname");
  var lastName = document.getElementById("lname");
  var email = document.getElementById("email");
  var password = document.getElementById("pass");
  var mobile = document.getElementById("mobile");
  var gender = document.getElementById("gender");

  var form = new FormData();
  form.append("firstname", firstName.value);
  form.append("lastname", lastName.value);
  form.append("em", email.value);
  form.append("pw", password.value);
  form.append("mob", mobile.value);
  form.append("gender", gender.value);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.readyState == 4) & (request.status == 200)) {
      var text = request.responseText;

      if (text == "success") {
        document.getElementById("msg").innerHTML = text;
        document.getElementById("msg").className = "bi bi-check2-circle fs-5";
        document.getElementById("alertdiv").className = "alert alert-success";
        document.getElementById("msgdiv").className = "d-block";
      } else {
        document.getElementById("msg").innerHTML = text;
        document.getElementById("msgdiv").className = "d-block";
      }
    }
  };

  request.open("POST", "signUpProcess.php", true);
  request.send(form);
}

function signIn() {
  var email = document.getElementById("email2");
  var password = document.getElementById("password2");
  var rememberme = document.getElementById("rememberme");

  var form = new FormData();
  form.append("email2", email.value);
  form.append("pass2", password.value);
  form.append("remember", rememberme.checked);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text2 = request.responseText;
      if (text2 == "success") {
        window.location = "home.php";
        document.getElementById("msg2").innerHTML = text2;
        document.getElementById("msg2").className =
          "bi bi-check2-circle fs-5  ";
        document.getElementById("alertdiv2").className = "alert alert-success";
        document.getElementById("msgdiv2").className = "d-block";
      } else {
        document.getElementById("msg2").innerHTML = text2;
        document.getElementById("msg2").className = "bi bi-x-octagon-fill fs-5";
        document.getElementById("alertdiv2").className = "alert alert-danger";
        document.getElementById("msgdiv2").className = "d-block";
      }
    }
  };

  request.open("POST", "signInProcess.php", true);
  request.send(form);
}

var bm;
function forgotPassword() {
  var sendEmail = document.getElementById("email2");

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var text3 = req.responseText;
      if (text3 == "success") {
        alert(
          "Verification code has sent to your Email. Please check your inbox"
        );
        var modal = document.getElementById("forgotPasswordModal");
        bm = new bootstrap.Modal(modal);
        bm.show();
      } else {
        alert(text3);
      }
    }
  };

  req.open("GET", "forgotPass.php?email2=" + sendEmail.value, true);
  req.send();
}

function ShowPass() {
  var input = document.getElementById("newpassinput");
  var eye = document.getElementById("eye1");

  if (input.type == "password") {
    input.type = "text";
    eye.className = "bi bi-eye-fill";
  } else {
    input.type = "password";
    eye.className = "bi bi-eye-slash-fill";
  }
}

function ShowRetypePass() {
  var input = document.getElementById("retypepassinput");
  var eye = document.getElementById("eye2");

  if (input.type == "password") {
    input.type = "text";
    eye.className = "bi bi-eye-fill";
  } else {
    input.type = "password";
    eye.className = "bi bi-eye-slash-fill";
  }
}

function resetpass() {
  var email = document.getElementById("email2");
  var newpw = document.getElementById("newpassinput");
  var retypepw = document.getElementById("retypepassinput");
  var verify = document.getElementById("verifycode");

  var form = new FormData();
  form.append("em", email.value);
  form.append("npw", newpw.value);
  form.append("rtpw", retypepw.value);
  form.append("vc", verify.value);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text4 = request.responseText;
      if (text4 == "success") {
        bm.hide();
        alert("Password Reset Success");
      } else {
        alert(text4);
      }
    }
  };

  request.open("POST", "resetPass.php", true);
  request.send(form);
}

function signout() {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text5 = request.responseText;
      if (text5 == "success") {
        window.location.reload();
      } else {
        alert(text5);
      }
    }
  };

  request.open("GET", "SignoutProcess.php", true);
  request.send();
}

function ADsignout() {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text5 = request.responseText;
      if (text5 == "success") {
        window.location.reload();
      } else {
        alert(text5);
      }
    }
  };

  request.open("GET", "ADSignoutProcess.php", true);
  request.send();
}

function updatePro() {
  var fname = document.getElementById("fname");
  var lname = document.getElementById("lname");
  var mobile = document.getElementById("mob");
  var line1 = document.getElementById("add01");
  var line2 = document.getElementById("add02");
  var province = document.getElementById("province");
  var district = document.getElementById("district");
  var city = document.getElementById("city");
  var postal = document.getElementById("postal");
  var image = document.getElementById("profileimg");

  var form = new FormData();
  form.append("fname", fname.value);
  form.append("lname", lname.value);
  form.append("mob", mobile.value);
  form.append("add01", line1.value);
  form.append("add02", line2.value);
  form.append("province", province.value);
  form.append("district", district.value);
  form.append("city", city.value);
  form.append("postal", postal.value);

  if (image.files.length == 0) {
    var confirmation = confirm(
      "Are you sure You don't need to update Profile image ??"
    );

    if (confirmation) {
      alert("You haven't selected any image");
    }
  } else {
    form.append("image", image.files[0]);
  }

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text6 = request.responseText;
      if (text6 == "success") {
        window.location.reload();
      } else {
        alert(text6);
      }
    }
  };

  request.open("POST", "updateProfileProcess.php", true);
  request.send(form);
}

function changeProductimg() {
  var image = document.getElementById("imageuploder");

  image.onchange = function () {
    var file_count = image.files.length;

    if (file_count <= 6) {
      for (var x = 0; x < file_count; x++) {
        var file = this.files[x];
        var url = window.URL.createObjectURL(file);

        document.getElementById("i" + x).src = url;
      }
    } else {
      alert("Please Select 6 images or Less than 6 images ");
    }
  };
}

function basicSearch() {
  var txt = document.getElementById("basic_search_txt");
  var Select = document.getElementById("basic_search_select");

  var basicform = new FormData();
  basicform.append("text", txt.value);
  basicform.append("search", Select.value);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var text14 = req.responseText;
      document.getElementById("basicSearchResult").innerHTML = text14;
    }
  };
  req.open("POST", "basicSearchProcess.php", true);
  req.send(basicform);
}

function checkValue(qty) {
  var input = document.getElementById("qty_input");

  if (input.value <= 0) {
    alert("Quantity Must be 1 or more");
    input.value = 1;
  } else if (input.value > qty) {
    alert("Maximum Quantity achieved");
    input.value = qty;
  }
}

function qty_inc(qty) {
  var input = document.getElementById("qty_input");
  if (input.value < qty) {
    var newVlaue = parseInt(input.value) + 1;
    input.value = newVlaue.toString();
  } else {
    alert("Maximum Quantity achieved");
  }
}

function qty_dec() {
  var input = document.getElementById("qty_input");
  if (input.value > 1) {
    var newVlaue = parseInt(input.value) - 1;
    input.value = newVlaue.toString();
  } else {
    alert("Quantity Must be 1 or more");
    input.value = 1;
  }
}

function addWishlist(id) {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var text16 = req.responseText;
      if (text16 == "Removed") {
        document.getElementById("heart" + id).style.className = "text-dark";
        window.location.reload();
      } else if (text16 == "added") {
        document.getElementById("heart" + id).style.className = "text-primary";
        window.location.reload();
      } else {
        alert(text16);
      }
    }
  };
  req.open("GET", "AddtoWatchlistProcess.php?id=" + id, true);
  req.send();
}

function removeFromWatchList(id) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text17 = request.responseText;
      if (text17 == "success") {
        window.location.reload();
      } else {
        alert(text17);
      }
    }
  };

  request.open("GET", "removeWatchListProcess.php?id=" + id, true);
  request.send();
}

function removeFromPurchasingHistory(id) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var textyy = request.responseText;
      if (textyy == "success") {
        window.location.reload();
      } else {
        alert(textyy);
      }
    }
  };

  request.open("GET", "removePurchasingHistory.php?id=" + id, true);
  request.send();
}

function searchWatchlist() {
  var search = document.getElementById("s").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text19 = request.responseText;
      document.getElementById("searchresult").innerHTML = text19;
    }
  };
  request.open("GET", "searchWatchlistProcess.php?s=" + search, true);
  request.send();
}

function searchCart() {
  var search = document.getElementById("c").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text21 = request.responseText;
      document.getElementById("searchresult").innerHTML = text21;
    }
  };
  request.open("GET", "searchCartProcess.php?c=" + search, true);
  request.send();
}

function AddtoCart(id) {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var text18 = req.responseText;
      alert(text18);
      window.location.reload();
    }
  };

  req.open("GET", "addTocartProcess.php?id=" + id, true);
  req.send();
}

function MinCart(id) {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var text18 = req.responseText;
      alert(text18);
      window.location.reload();
    }
  };

  req.open("GET", "minCartProcess.php?id=" + id, true);
  req.send();
}

function deleteFromCart(id) {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var text20 = req.responseText;
      if (text20 == "successfuly Removed") {
        alert("Product Removed from the cart");
        window.location.reload();
      } else {
        alert(text20);
      }
    }
  };

  req.open("GET", "deleteFromCartProcess.php?id=" + id, true);
  req.send();
}

function payNow(id) {
  var qty = document.getElementById("qty_input").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;

      var obj = JSON.parse(response);

      var mail = obj["umail"];
      var amount = obj["amount"];

      if (response == 1) {
        alert("Please Login Or Sign Up");
        window.location = "index.php";
      } else if (response == 2) {
        alert("Please update your profile.");
        window.location = "userprofile.php";
      } else {
        // Payment completed. It can be a successful failure.
        payhere.onCompleted = function onCompleted(orderId) {
          console.log("Payment completed. OrderID:" + orderId);
          saveInvoice(orderId, id, mail, amount, qty);
        };

        // Payment window closed
        payhere.onDismissed = function onDismissed() {
          // Note: Prompt user to pay again or show an error page
          console.log("Payment dismissed");
        };

        // Error occurred
        payhere.onError = function onError(error) {
          // Note: show an error page
          console.log("Error:" + error);
        };

        // Put the payment variables here
        var payment = {
          sandbox: true,
          merchant_id: obj["mid"], // Replace your Merchant ID
          return_url:
            "http://localhost/ceOnlineStore/SingleProductView.php?id=1" + id, // Important
          cancel_url:
            "http://localhost/ceOnlineStore/SingleProductView.php?id=1" + id, // Important
          notify_url: "http://sample.com/notify",
          order_id: obj["id"],
          items: obj["item"],
          amount: amount + ".00",
          currency: "LKR",
          hash: obj["hash"], // *Replace with generated hash retrieved from backend
          first_name: obj["fname"],
          last_name: obj["lname"],
          email: mail,
          phone: obj["mobile"],
          address: obj["address"],
          city: obj["city"],
          country: "Sri Lanka",
          delivery_address: obj["address"],
          delivery_city: obj["city"],
          delivery_country: "Sri Lanka",
          custom_1: "",
          custom_2: "",
        };

        // Show the payhere.js popup, when "PayHere Pay" is clicked
        // document.getElementById('payhere-payment').onclick = function (e) {
        payhere.startPayment(payment);
        // };
      }
    }
  };

  request.open("GET", "BuyNowProcess.php?id=" + id + "&qty=" + qty, true);
  request.send();
}

function saveInvoice(orderId, id, mail, amount, qty) {
  var form = new FormData();
  form.append("o", orderId);
  form.append("i", id);
  form.append("m", mail);
  form.append("a", amount);
  form.append("q", qty);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;

      if (response == "success") {
        window.location = "invoice.php?id=" + orderId;
      } else {
        alert(response);
      }
    }
  };

  request.open("POST", "saveInvoice.php", true);
  request.send(form);
}

function printInvoice() {
  var body = document.body.innerHTML;
  var page = document.getElementById("page").innerHTML;
  document.body.innerHTML = page;
  window.print();
  document.body.innerHTML = body;
}

function changeimg() {
  var view = document.getElementById("viewimg"); //Get id from profile image
  var filechooser = document.getElementById("profileimg"); //Get file chooser

  filechooser.onchange = function () {
    var file1 = this.files[0];
    var url = window.URL.createObjectURL(file1);
    view.src = url;
  };
}

function updatePro() {
  var fname = document.getElementById("fname");
  var lname = document.getElementById("lname");
  var mobile = document.getElementById("mob");
  var line1 = document.getElementById("add01");
  var line2 = document.getElementById("add02");
  var province = document.getElementById("province");
  var district = document.getElementById("district");
  var city = document.getElementById("city");
  var postal = document.getElementById("postal");
  var image = document.getElementById("profileimg");

  var form = new FormData();
  form.append("fname", fname.value);
  form.append("lname", lname.value);
  form.append("mob", mobile.value);
  form.append("add01", line1.value);
  form.append("add02", line2.value);
  form.append("province", province.value);
  form.append("district", district.value);
  form.append("city", city.value);
  form.append("postal", postal.value);

  if (image.files.length == 0) {
    var confirmation = confirm(
      "Are you sure You don't need to update Profile image ??"
    );

    if (confirmation) {
      alert("You haven't selected any image");
    }
  } else {
    form.append("image", image.files[0]);
  }

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text6 = request.responseText;
      if (text6 == "success") {
        window.location.reload();
      } else {
        alert(text6);
      }
    }
  };

  request.open("POST", "updateProfileProcess.php", true);
  request.send(form);
}

function saveFeedback(id) {
  var type = 0;
  if (document.getElementById("type1").checked) {
    type = 1;
  } else if (document.getElementById("type2").checked) {
    type = 2;
  } else if (document.getElementById("type3").checked) {
    type = 3;
  } else if (document.getElementById("type4").checked) {
    type = 4;
  } else if (document.getElementById("type5").checked) {
    type = 5;
  }

  var feedback = document.getElementById("feed");

  var form = new FormData();
  form.append("pid", id);
  form.append("t", type);
  form.append("f", feedback.value);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var response = request.responseText;

      if (response == "Review Added Successfully") {
        window.location.reload();
        document.getElementById("addmsg").innerHTML = text7;
        document.getElementById("addmsg").className =
          "bi bi-check2-circle fs-5";
        document.getElementById("addalertdiv").className =
          "alert alert-success";
        document.getElementById("addmsgdiv").className = "d-block";
      } else {
        document.getElementById("addmsg").innerHTML = response;
        document.getElementById("addmsg").className =
          "bi bi-x-octagon-fill fs-5";
        document.getElementById("addalertdiv").className = "alert alert-danger";
        document.getElementById("addmsgdiv").className = "d-block";
      }
    }
  };

  request.open("POST", "saveFeedbackProcess.php", true);
  request.send(form);
}

var av;
function adminVerification() {
  var email = document.getElementById("e");

  var adminForm = new FormData();
  adminForm.append("e", email.value);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var t = req.responseText;
      if (t == "success") {
        var adminVerificationModal =
          document.getElementById("veriFicationModal");
        av = new bootstrap.Modal(adminVerificationModal);
        av.show();
      } else {
        alert(t);
      }
    }
  };
  req.open("POST", "adminVeriFicationProcess.php", true);
  req.send(adminForm);
}

function verify() {
  var VeriFication = document.getElementById("vCode");

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var t = req.responseText;
      if (t == "success") {
        av.hide();
        window.location = "adminPanel.php";
      } else {
        alert(t);
      }
    }
  };
  req.open("GET", "veriFicationProcess.php?v=" + VeriFication.value, true);
  req.send();
}

function changeStatus(id) {
  var product_id = id;

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var text10 = r.responseText;

      if (text10 == "Product Deactivated") {
        window.location.reload();
        document.getElementById("activemsg").innerHTML = text10;
        document.getElementById("activemsg").className =
          "bi bi-check2-circle fs-5";
        document.getElementById("activealertdiv").className =
          "alert alert-danger";
        document.getElementById("activemsgdiv").className = "d-block";
      } else if (text10 == "Product Activated") {
        window.location.reload();
        document.getElementById("activemsg").innerHTML = text10;
        document.getElementById("activemsg").className =
          "bi bi-check2-circle fs-5";
        document.getElementById("activealertdiv").className =
          "alert alert-success";
        document.getElementById("activemsgdiv").className = "d-block";
      } else {
        alert(text10);
      }
    }
  };

  r.open("GET", "ChangeStatusProcess.php?p=" + product_id, true);
  r.send();
}

function sort1(x) {
  // var search = document.getElementById("search");

  var time = "0";

  if (document.getElementById("new").checked) {
    time = "1";
  } else if (document.getElementById("old").checked) {
    time = "2";
  }

  var qty = "0";

  if (document.getElementById("high").checked) {
    qty = "1";
  } else if (document.getElementById("low").checked) {
    qty = "2";
  }

  var price = "0";

  if (document.getElementById("hprice").checked) {
    price = "1";
  } else if (document.getElementById("lprice").checked) {
    price = "2";
  }

  var cat = "0";

  if (document.getElementById("Footwear").checked) {
    cat = "1";
  } else if (document.getElementById("Hand").checked) {
    cat = "2";
  } else if (document.getElementById("Fancy").checked) {
    cat = "3";
  } else if (document.getElementById("Beauty").checked) {
    cat = "4";
  }

  var sortproductform = new FormData();

  // sortproductform.append("search", search.value);
  sortproductform.append("time", time);
  sortproductform.append("qty", qty);
  sortproductform.append("cat", cat);
  sortproductform.append("price", price);
  sortproductform.append("page", x);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text11 = request.responseText;

      document.getElementById("sort").innerHTML = text11;
    }
  };

  request.open("POST", "SortProcess.php", true);
  request.send(sortproductform);
}

function clearSort() {
  window.location.reload();
}

function sendId(id) {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var text12 = req.responseText;
      if (text12 == "success") {
        window.location = "updateProduct.php";
      } else {
        alert(text12);
      }
    }
  };

  req.open("GET", "SendProductID.php?id=" + id, true);
  req.send();
}

function Updateproduct() {
  var qty = document.getElementById("upqty");
  var dwc = document.getElementById("updwc");
  var doc = document.getElementById("updoc");
  var desc = document.getElementById("updesc");
  var image = document.getElementById("imageuploder");

  var Updateform = new FormData();
  Updateform.append("upqty", qty.value);
  Updateform.append("updwc", dwc.value);
  Updateform.append("updoc", doc.value);
  Updateform.append("updesc", desc.value);

  var img_count = image.files.length;

  for (var x = 0; x < img_count; x++) {
    Updateform.append("i" + x, image.files[x]);
  }

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text13 = request.responseText;
      if (text13 == "Product has been updated Successfully !!") {
        window.location.reload();
        document.getElementById("addmsg").innerHTML = text13;
        document.getElementById("addmsg").className =
          "bi bi-check2-circle fs-5";
        document.getElementById("addalertdiv").className =
          "alert alert-success";
        document.getElementById("addmsgdiv").className = "d-block";
      } else {
        document.getElementById("addmsg").innerHTML = text13;
        document.getElementById("addmsg").className =
          "bi bi-x-octagon-fill fs-5";
        document.getElementById("addalertdiv").className = "alert alert-danger";
        document.getElementById("addmsgdiv").className = "d-block";
      }
    }
  };

  request.open("POST", "updateProductProcess.php", true);
  request.send(Updateform);
}

function changeInvStatus(id) {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var t = req.responseText;

      if (t == 1) {
        document.getElementById("btn" + id).innerHTML =
          "Packaging";
        document.getElementById("btn" + id).classList =
          "rounded-3 text-white my-2 style='background-color: #d10024; border: none; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;'";
      } else if (t == 2) {
        document.getElementById("btn" + id).innerHTML =
          "Dispatching";
        document.getElementById("btn" + id).classList =
        "rounded-3 text-white my-2 style='background-color: #ca00d1; border: none; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;'";
      } else if (t == 3) {
        document.getElementById("btn" + id).innerHTML =
          "Shipping";
        document.getElementById("btn" + id).classList =
        "rounded-3 text-white my-2 style='background-color: #7d00d1; border: none; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;'";
      } else if (t == 4) {
        document.getElementById("btn" + id).innerHTML =
          "Delivering";
        document.getElementById("btn" + id).classList =
        "rounded-3 text-white my-2 style='background-color: #1500d1; border: none; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;'";
      } else if (t == 5) {
        document.getElementById("btn" + id).innerHTML =
          "Completed";
        document.getElementById("btn" + id).classList =
        "rounded-3 text-white my-2 disabled style='background-color: #01944f; border: none; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;'";
      } else {
        window.location.reload();
      }
    }
  };

  req.open("GET", "ChangeInvStatusProcess.php?id=" + id, true);
  req.send();
}

function searchInvoiceID() {
  var txt = document.getElementById("searchtxt").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var t = request.responseText;

      document.getElementById("viewarea").innerHTML = t;
    }
  };

  request.open("GET", "SearchInvoiceIDProcess.php?id=" + txt, true);
  request.send();
}

function findSellings() {
  var from = document.getElementById("from").value;
  var to = document.getElementById("to").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var t = request.responseText;
      document.getElementById("viewarea").innerHTML = t;
    }
  };

  request.open("GET", "findSellingsProcess.php?f=" + from + "&t=" + to, true);
  request.send();
}

function printDiv() {
  var orginalContent = document.body.innerHTML;
  var printArea = document.getElementById("printArea").innerHTML;
  document.body.innerHTML = printArea;
  window.print();
  document.body.innerHTML = orginalContent;
}
request.open("POST", path, true);
request.send(fd);

function addProduct() {
  var category = document.getElementById("category");
  var title = document.getElementById("title");
  var qty = document.getElementById("qty_input");
  var cost = document.getElementById("cost");
  var dwc = document.getElementById("dwc");
  var doc = document.getElementById("doc");
  var description = document.getElementById("desc");
  var image = document.getElementById("imageuploder");

  var form = new FormData();

  form.append("category", category.value);
  form.append("title", title.value);
  form.append("qty", qty.value);
  form.append("cost", cost.value);
  form.append("dwc", dwc.value);
  form.append("doc", doc.value);
  form.append("desc", description.value);

  var file_count = image.files.length;

  for (var x = 0; x < file_count; x++) {
    form.append("img" + x, image.files[x]);
  }

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text7 = request.responseText;

      if (text7 == "Product Saved Successfully") {
        document.getElementById("addmsg").innerHTML = text7;
        document.getElementById("addmsg").className =
          "bi bi-x-octagon-fill fs-5";
        document.getElementById("addalertdiv").className = "alert alert-danger";
        document.getElementById("addmsgdiv").className = "d-block";
      } else {
        window.location.reload();
        document.getElementById("addmsg").innerHTML = text7;
        document.getElementById("addmsg").className =
          "bi bi-check2-circle fs-5";
        document.getElementById("addalertdiv").className =
          "alert alert-success";
        document.getElementById("addmsgdiv").className = "d-block";
      }
    }
  };

  request.open("POST", "AddProductProcess.php", true);
  request.send(form);
}

function blockUser(email) {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var txt = req.responseText;
      if (txt == "Blocked") {
        document.getElementById("UB" + email).innerHTML = "Unblock";
        document.getElementById("UB" + email).classList =
          "rounded-3 text-white my-2 style='background-color: #2b2d42; border: none; width: 75px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;'";
        window.location.reload();
      } else if (txt == "UnBlocked") {
        document.getElementById("UB" + email).innerHTML = "Block";
        document.getElementById("UB" + email).classList =
          "rounded-3 text-white my-2 style='background-color: #0073e6; border: none; width: 75px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;'";
        window.location.reload();
      } else {
        alert(txt);
      }
    }
  };

  req.open("GET", "UserBlockProcess.php?email=" + email, true);
  req.send();
}

function blockProduct(id) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var txt = request.responseText;
      if (txt == "unblocked") {
        document.getElementById("pb" + id).innerHTML = "Unblock";
        document.getElementById("pb" + id).classList =
          "rounded-3 text-white my-2 style='background-color: #2b2d42; border: none; width: 75px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;'";
        window.location.reload();
      } else if (txt == "blocked") {
        document.getElementById("pb" + id).innerHTML = "Block";
        document.getElementById("pb" + id).classList =
          "rounded-3 text-white my-2 style='background-color: #0073e6; border: none; width: 75px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;'";
        window.location.reload();
      } else {
        alert(txt);
      }
    }
  };

  request.open("GET", "productBlockProcess.php?id=" + id, true);
  request.send();
}

function searchMU() {
  var search = document.getElementById("mu").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text = request.responseText;
      document.getElementById("searchResults").innerHTML = text;
    }
  };
  request.open("GET", "SearchInmanageUser.php?mu=" + search, true);
  request.send();
}

function searchMP() {
  var search = document.getElementById("mp").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text = request.responseText;
      document.getElementById("searchResults").innerHTML = text;
    }
  };
  request.open("GET", "SearchINmanageProduct.php?mp=" + search, true);
  request.send();
}

var cm;
function addNewCategory() {
  var mo = document.getElementById("addCategoryModal");
  cm = new bootstrap.Modal(mo);
  cm.show();
}

var vc;
var e;
var m;

function verifyCategory() {
  var mcm = document.getElementById("addCategoryVerificationModal");
  vc = new bootstrap.Modal(mcm);

  e = document.getElementById("e").value;
  m = document.getElementById("m").value;

  var f = new FormData();

  f.append("email", e);
  f.append("name", m);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var txt = req.responseText;
      if (txt == "success") {
        cm.hide();
        vc.show();
      } else {
        alert(txt);
      }
    }
  };
  req.open("POST", "addNewCategoryPRocess.php", true);
  req.send(f);
}

function saveCategory() {
  var txt = document.getElementById("modaltxt").value;

  var form = new FormData();
  form.append("t", txt);
  form.append("e", e);
  form.append("m", m);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var t = req.responseText;
      if (t == "success") {
        vc.hide();
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  req.open("POST", "SaveCategoryProcess.php", true);
  req.send(form);
}

function addCatImg() {
  var category = document.getElementById("category1");
  var image = document.getElementById("imageuploder");

  var form = new FormData();

  form.append("category", category.value);

  var file_count = image.files.length;

  for (var x = 0; x < file_count; x++) {
    form.append("img" + x, image.files[x]);
  }

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text7 = request.responseText;

      if (text7 == "Product Saved Successfully") {
        document.getElementById("addmsg").innerHTML = text7;
        document.getElementById("addmsg").className =
          "bi bi-x-octagon-fill fs-5";
        document.getElementById("addalertdiv").className = "alert alert-danger";
        document.getElementById("addmsgdiv").className = "d-block";
      } else {
        window.location.reload();
        document.getElementById("addmsg").innerHTML = text7;
        document.getElementById("addmsg").className =
          "bi bi-check2-circle fs-5";
        document.getElementById("addalertdiv").className =
          "alert alert-success";
        document.getElementById("addmsgdiv").className = "d-block";
      }
    }
  };

  request.open("POST", "AddCatImg.php", true);
  request.send(form);
}

function blockUser(email) {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var txt = req.responseText;
      if (txt == "Blocked") {
        document.getElementById("UB" + email).innerHTML = "Unblock";
        document.getElementById("UB" + email).classList =
          "rounded-3 text-white my-2 style='background-color: #2b2d42; border: none; width: 75px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;'";
        window.location.reload();
      } else if (txt == "UnBlocked") {
        document.getElementById("UB" + email).innerHTML = "Block";
        document.getElementById("UB" + email).classList =
          "rounded-3 text-white my-2 style='background-color: #d10024; border: none; width: 75px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;'";
        window.location.reload();
      } else {
        alert(txt);
      }
    }
  };

  req.open("GET", "UserBlockProcess.php?email=" + email, true);
  req.send();
}

function blockProduct(id) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var txt = request.responseText;
      if (txt == "unblocked") {
        document.getElementById("pb" + id).innerHTML = "Unblock";
        document.getElementById("pb" + id).classList =
          "rounded-3 text-white my-2 style='background-color: #2b2d42; border: none; width: 75px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;'";
        window.location.reload();
      } else if (txt == "blocked") {
        document.getElementById("pb" + id).innerHTML = "Block";
        document.getElementById("pb" + id).classList =
          "rounded-3 text-white my-2 style='background-color: #d10024; border: none; width: 75px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;'";
        window.location.reload();
      } else {
        alert(txt);
      }
    }
  };

  request.open("GET", "productBlockProcess.php?id=" + id, true);
  request.send();
}

function searchMU() {
  var search = document.getElementById("mu").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text = request.responseText;
      document.getElementById("searchResults").innerHTML = text;
    }
  };
  request.open("GET", "SearchInmanageUser.php?mu=" + search, true);
  request.send();
}

function searchMP() {
  var search = document.getElementById("mp").value;

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text = request.responseText;
      document.getElementById("searchResults").innerHTML = text;
    }
  };
  request.open("GET", "SearchINmanageProduct.php?mp=" + search, true);
  request.send();
}

var cm;
function addNewCategory() {
  var mo = document.getElementById("addCategoryModal");
  cm = new bootstrap.Modal(mo);
  cm.show();
}

var vc;
var e;
var m;

function verifyCategory() {
  var mcm = document.getElementById("addCategoryVerificationModal");
  vc = new bootstrap.Modal(mcm);

  e = document.getElementById("e").value;
  m = document.getElementById("m").value;

  var f = new FormData();

  f.append("email", e);
  f.append("name", m);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var txt = req.responseText;
      if (txt == "success") {
        cm.hide();
        vc.show();
      } else {
        alert(txt);
      }
    }
  };
  req.open("POST", "addNewCategoryPRocess.php", true);
  req.send(f);
}

function saveCategory() {
  var txt = document.getElementById("modaltxt").value;

  var form = new FormData();
  form.append("t", txt);
  form.append("e", e);
  form.append("m", m);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      var t = req.responseText;
      if (t == "success") {
        vc.hide();
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  req.open("POST", "SaveCategoryProcess.php", true);
  req.send(form);
}

function addCatImg() {
  var category = document.getElementById("category1");
  var image = document.getElementById("imageuploder");

  var form = new FormData();

  form.append("category", category.value);

  var file_count = image.files.length;

  for (var x = 0; x < file_count; x++) {
    form.append("img" + x, image.files[x]);
  }

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var text7 = request.responseText;

      if (text7 == "Product Saved Successfully") {
        document.getElementById("addmsg").innerHTML = text7;
        document.getElementById("addmsg").className =
          "bi bi-x-octagon-fill fs-5";
        document.getElementById("addalertdiv").className = "alert alert-danger";
        document.getElementById("addmsgdiv").className = "d-block";
      } else {
        window.location.reload();
        document.getElementById("addmsg").innerHTML = text7;
        document.getElementById("addmsg").className =
          "bi bi-check2-circle fs-5";
        document.getElementById("addalertdiv").className =
          "alert alert-success";
        document.getElementById("addmsgdiv").className = "d-block";
      }
    }
  };

  request.open("POST", "AddCatImg.php", true);
  request.send(form);
}
