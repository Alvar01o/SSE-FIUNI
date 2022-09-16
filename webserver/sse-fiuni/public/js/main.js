jQuery(document).ready(function () {
  if (jQuery('#ingreso').length) {
    flatpickr('#ingreso', {
      locale: 'es', // locale for this instance only
      allowInput: true, // prevent "readonly" prop
      onReady: function (selectedDates, dateStr, instance) {
        let el = instance.element
        function preventInput(event) {
          event.preventDefault()
          return false
        }
        el.onkeypress = el.onkeydown = el.onkeyup = preventInput // disable key events
        el.onpaste = preventInput // disable pasting using mouse context menu

        el.style.caretColor = 'transparent' // hide blinking cursor
        el.style.cursor = 'pointer' // override cursor hover type text
        el.style.color = '#585858' // prevent text color change on focus
        el.style.backgroundColor = '#f7f7f7' // prevent bg color change on focus
      },
    })
  }

  if (jQuery('#egreso').length) {
    flatpickr('#egreso', {
      locale: 'es', // locale for this instance only
      allowInput: true, // prevent "readonly" prop
      onReady: function (selectedDates, dateStr, instance) {
        let el = instance.element
        function preventInput(event) {
          event.preventDefault()
          return false
        }
        el.onkeypress = el.onkeydown = el.onkeyup = preventInput // disable key events
        el.onpaste = preventInput // disable pasting using mouse context menu

        el.style.caretColor = 'transparent' // hide blinking cursor
        el.style.cursor = 'pointer' // override cursor hover type text
        el.style.color = '#585858' // prevent text color change on focus
        el.style.backgroundColor = '#f7f7f7' // prevent bg color change on focus
      },
    })
  }

  // Example starter JavaScript for disabling form submissions if there are invalid fields
  ;(function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms).forEach(function (form) {
      form.addEventListener(
        'submit',
        function (event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }

          form.classList.add('was-validated')
        },
        false,
      )
    })
  })()
})
