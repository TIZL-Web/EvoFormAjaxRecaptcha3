# EvoFormAjaxRecaptcha3
Evolution CMS Form with ajax and reCaptcha3

- Create reCaptchaV3 for your web-site: https://www.google.com/recaptcha/admin/create
- Create snippet: "send_contact_form" (file send_contact_form_snippet). Insert Your reCaptcha SecretKey in the snippet.
- Create page "ContactFormSender" with alias "sendform", template (blank) and call snippet [[send_contact_form]] in the content section.
- Insert form code to the page (file form.html).
- Add reCaptcha script on the page with contact form. (<script async src="https://www.google.com/recaptcha/api.js?render=YOUR_RECAPTCHA_PUBLIC_KEY"></script>).
- Add form.js script on the page with contact form (file form.js). Insert Your reCaptcha PublicKey in the JS code.
- Add styles from form.css.
