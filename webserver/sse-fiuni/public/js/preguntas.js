var validadorWizard = (function () {
  let stepGlobal = 1

  function ss_editarOpcion(ev) {
    let td = jQuery(ev).parent().parent().parent().find('td').first()
    td.parent().find('button.ss_edit_btn').addClass('d-none')
    td.parent().find('button.ss_check_btn').removeClass('d-none')
    td.html(td.children())
    td.find('input').attr('type', 'text')
  }

  function ss_guardarOpcion(ev) {
    let td = jQuery(ev).parent().parent().parent().find('td').first()
    td.parent().find('button.ss_edit_btn').removeClass('d-none')
    td.parent().find('button.ss_check_btn').addClass('d-none')
    td.prepend(td.find('input').val())
    td.find('input').attr('type', 'hidden')
  }

  function initSeleccionSimple() {
    jQuery('input[name="ss_opcion_agg"]').on('keypress', function (e) {
      if (e.which == 13) {
        jQuery('#ss_add_btn').click()
      }
    })

    jQuery('#ss_add_btn').on('click', function () {
      if (jQuery('input[name="ss_opcion_agg"]').val() == '') {
        return false
      } else {
        let strOption = jQuery('input[name="ss_opcion_agg"]').val()
        jQuery('#ss_options_table').append(
          `
                    <tr>
                        <td>` +
            strOption +
            `
                            <input type="hidden" name="opcion[]" style="outline: none;border: none;" value="` +
            strOption +
            `"/>
                        </td>
                        <td class="text-end">
                            <div class="opcion_contenedor">
                                <button class="btn p-0 d-none ss_check_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.ss_guardarOpcion(this)" title="Guardar"><span class="text-500 fas fa-check"></span></button>
                                <button class="btn p-0 ss_edit_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.ss_editarOpcion(this)" title="Editar"><span class="text-500 fas fa-edit"></span></button>
                                <button class="btn p-0 ms-2 ss_eliminar_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.eliminarOpcion(this) "title="Eliminar"><span class="text-500 fas fa-trash-alt"></span></button>
                            </div>
                        </td>
                    </tr>
                    `,
        )
        jQuery('input[name="ss_opcion_agg"]').val('')
      }
    })
  }
  function eliminarOpcion(ev) {
    jQuery(ev).parent().parent().parent().remove()
  }

  function sm_editarOpcion(ev) {
    let td = jQuery(ev).parent().parent().parent().find('td').first()
    td.parent().find('button.sm_edit_btn').addClass('d-none')
    td.parent().find('button.sm_check_btn').removeClass('d-none')
    td.html(td.children())
    td.find('input').attr('type', 'text')
  }

  function sm_guardarOpcion(ev) {
    let td = jQuery(ev).parent().parent().parent().find('td').first()
    td.parent().find('button.sm_edit_btn').removeClass('d-none')
    td.parent().find('button.sm_check_btn').addClass('d-none')
    td.prepend(td.find('input').val())
    td.find('input').attr('type', 'hidden')
  }

  function smj_agg_otro(id_contenedor) {
    if (jQuery('#otro' + id_contenedor).length == 0) {
      jQuery('#' + id_contenedor).append(
        `
                <tr id="otro` +
          id_contenedor +
          `">
                    <td> Otro
                        <input type="hidden" name="opcion[]" style="outline: none;border: none;" value="Otro"/>
                    </td>
                    <td class="text-center">
                        <div class="opcion_contenedor">
                            <button class="btn p-0 d-none smj_check_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.smj_guardarOpcion(this)" title="Guardar"><span class="text-500 fas fa-check"></span></button>
                            <button class="btn p-0 smj_edit_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.smj_editarOpcion(this)" title="Editar"><span class="text-500 fas fa-edit"></span></button>
                            <button class="btn p-0 ms-2 smj_eliminar_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.eliminarOpcion(this) "title="Eliminar"><span class="text-500 fas fa-trash-alt"></span></button>
                        </div>
                    </td>
                    <td class="text-center">
                        <input type="checkbox" checked="checked" name="justificacion[]">
                    </td>
                </tr>
                `,
      )
    }
  }

  function smj_editarOpcion(ev) {
    let td = jQuery(ev).parent().parent().parent().find('td').first()
    td.parent().find('button.smj_edit_btn').addClass('d-none')
    td.parent().find('button.smj_check_btn').removeClass('d-none')
    td.html(td.children())
    td.find('input').attr('type', 'text')
  }

  function smj_guardarOpcion(ev) {
    let td = jQuery(ev).parent().parent().parent().find('td').first()
    td.parent().find('button.smj_edit_btn').removeClass('d-none')
    td.parent().find('button.smj_check_btn').addClass('d-none')
    td.prepend(td.find('input').val())
    td.find('input').attr('type', 'hidden')
  }

  function ssj_agg_otro(id_contenedor) {
    if (jQuery('#otro' + id_contenedor).length == 0) {
      jQuery('#' + id_contenedor).append(
        `
            <tr id="otro` +
          id_contenedor +
          `">
                <td> Otro
                </td>
                <td class="text-center">
                    <div class="opcion_contenedor">
                        <button class="btn p-0 d-none ssj_check_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.ssj_guardarOpcion(this)" title="Guardar"><span class="text-500 fas fa-check"></span></button>
                        <button class="btn p-0 ssj_edit_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.ssj_editarOpcion(this)" title="Editar"><span class="text-500 fas fa-edit"></span></button>
                        <button class="btn p-0 ms-2 ssj_eliminar_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.eliminarOpcion(this) "title="Eliminar"><span class="text-500 fas fa-trash-alt"></span></button>
                    </div>
                </td>
                <td class="text-center">
                    <input type="checkbox" checked="checked" name="justificacion[]">
                </td>
            </tr>
            `,
      )
    }
  }

  function ssj_editarOpcion(ev) {
    let td = jQuery(ev).parent().parent().parent().find('td').first()
    td.parent().find('button.ssj_edit_btn').addClass('d-none')
    td.parent().find('button.ssj_check_btn').removeClass('d-none')
    td.html(td.children())
    td.find('input').attr('type', 'text')
  }

  function ssj_guardarOpcion(ev) {
    let td = jQuery(ev).parent().parent().parent().find('td').first()
    td.parent().find('button.ssj_edit_btn').removeClass('d-none')
    td.parent().find('button.ssj_check_btn').addClass('d-none')
    td.prepend(td.find('input').val())
    td.find('input').attr('type', 'hidden')
  }

  function initSeleccionMultipleJustificacion() {
    jQuery('input[name="smj_opcion_agg"]').on('keypress', function (e) {
      if (e.which == 13) {
        jQuery('#smj_add_btn').click()
      }
    })

    jQuery('#smj_add_btn').on('click', function () {
      if (jQuery('input[name="smj_opcion_agg"]').val() == '') {
        return false
      } else {
        let strOption = jQuery('input[name="smj_opcion_agg"]').val()
        jQuery('#smj_options_table').append(
          `
                    <tr>
                        <td>` +
            strOption +
            `
                            <input type="hidden" name="opcion[]" style="outline: none;border: none;" value="` +
            strOption +
            `"/>
                        </td>
                        <td class="text-center">
                            <div class="opcion_contenedor">
                                <button class="btn p-0 d-none smj_check_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.smj_guardarOpcion(this)" title="Guardar"><span class="text-500 fas fa-check"></span></button>
                                <button class="btn p-0 smj_edit_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.smj_editarOpcion(this)" title="Editar"><span class="text-500 fas fa-edit"></span></button>
                                <button class="btn p-0 ms-2 smj_eliminar_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.eliminarOpcion(this) "title="Eliminar"><span class="text-500 fas fa-trash-alt"></span></button>
                            </div>
                        </td>
                        <td class="text-center">
                        </td>
                    </tr>`,
        )
        jQuery('input[name="smj_opcion_agg"]').val('')
      }
    })
  }
  function initSeleccionJustificacion() {
    jQuery('input[name="ssj_opcion_agg"]').on('keypress', function (e) {
      if (e.which == 13) {
        jQuery('#ssj_add_btn').click()
      }
    })

    jQuery('#ssj_add_btn').on('click', function () {
      if (jQuery('input[name="ssj_opcion_agg"]').val() == '') {
        return false
      } else {
        let strOption = jQuery('input[name="ssj_opcion_agg"]').val()
        jQuery('#ssj_options_table').append(
          `
                    <tr>
                        <td>` +
            strOption +
            `
                            <input type="hidden" name="opcion[]" style="outline: none;border: none;" value="` +
            strOption +
            `"/>
                        </td>
                        <td class="text-center">
                            <div class="opcion_contenedor">
                                <button class="btn p-0 d-none ssj_check_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.ssj_guardarOpcion(this)" title="Guardar"><span class="text-500 fas fa-check"></span></button>
                                <button class="btn p-0 ssj_edit_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.ssj_editarOpcion(this)" title="Editar"><span class="text-500 fas fa-edit"></span></button>
                                <button class="btn p-0 ms-2 ssj_eliminar_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.eliminarOpcion(this) "title="Eliminar"><span class="text-500 fas fa-trash-alt"></span></button>
                            </div>
                        </td>
                        <td class="text-center">

                        </td>
                    </tr>
                    `,
        )
        jQuery('input[name="ssj_opcion_agg"]').val('')
      }
    })
  }

  function initSeleccionMultiple() {
    if (jQuery('input[name="sm_opcion_agg"]')) {
      jQuery('input[name="sm_opcion_agg"]').on('keypress', function (e) {
        if (e.which == 13) {
          jQuery('#sm_add_btn').click()
        }
      })

      jQuery('#sm_add_btn').on('click', function () {
        if (jQuery('input[name="sm_opcion_agg"]').val() == '') {
          return false
        } else {
          let strOption = jQuery('input[name="sm_opcion_agg"]').val()
          jQuery('#sm_options_table').append(
            `
                    <tr>
                        <td>` +
              strOption +
              `
                            <input type="hidden" name="opcion[]" style="outline: none;border: none;" value="` +
              strOption +
              `"/>
                        </td>
                        <td class="text-end">
                            <div class="opcion_contenedor">
                                <button class="btn p-0 d-none sm_check_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.sm_guardarOpcion(this)" title="Guardar"><span class="text-500 fas fa-check"></span></button>
                                <button class="btn p-0 sm_edit_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.sm_editarOpcion(this)" title="Editar"><span class="text-500 fas fa-edit"></span></button>
                                <button class="btn p-0 ms-2 sm_eliminar_btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" onclick="validadorWizard.eliminarOpcion(this) "title="Eliminar"><span class="text-500 fas fa-trash-alt"></span></button>
                            </div>
                        </td>
                    </tr>
                    `,
          )
          jQuery('input[name="sm_opcion_agg"]').val('')
        }
      })
    }
  }

  function init() {
    eventosEnPrevioYsiguiente()
    if (jQuery('input[name="sm_opcion_agg"]').length) {
      initSeleccionMultiple()
    }
    if (jQuery('input[name="ssj_opcion_agg"]').length) {
      initSeleccionJustificacion()
    }
    if (jQuery('input[name="smj_opcion_agg"]').length) {
      initSeleccionMultipleJustificacion()
    }
    if (jQuery('input[name="ss_opcion_agg"]').length) {
      initSeleccionSimple()
    }
  }

  function eventosEnPrevioYsiguiente() {
    jQuery('li.previous > button').on('click', function () {
      jQuery('li.previous > button').toggleClass('d-none')
      let step = jQuery('ul.nav-wizard')
        .find('li.nav-item')
        .get(stepGlobal - 1)
      stepGlobal--
      let prevtStep = jQuery('ul.nav-wizard')
        .find('li.nav-item')
        .get(stepGlobal - 1)
      jQuery(step).find('a').removeClass('active')
      jQuery(prevtStep).find('a').removeClass('done')
      jQuery(prevtStep).find('a').addClass('active')
      if (stepGlobal == 1) {
        jQuery('#step-tab1').toggleClass('active')
        jQuery('#step-tab2').toggleClass('active')
      } else if (stepGlobal == 2) {
        jQuery('#step-tab2').toggleClass('active')
        jQuery('#step-tab3').toggleClass('active')
      }
    })

    jQuery('#nextStep').on('click', function (e) {
      let selected = jQuery('#selector_de_tipo').val()
      jQuery('.tipo_pregunta').each(function (k, e) {
        if (!jQuery(e).hasClass('d-none')) {
          jQuery(e).addClass('d-none')
        }
      })

      jQuery('#' + selected).toggleClass('d-none')

      if (stepGlobal == 1) {
        //falta validacion
        let step = jQuery('ul.nav-wizard').find('li.nav-item').get(0)
        let nextStep = jQuery('ul.nav-wizard').find('li.nav-item').get(1)
        jQuery(step).find('a').addClass('done')
        jQuery(nextStep).find('a').addClass('active')
        jQuery('#step-tab1').toggleClass('active')
        jQuery('#step-tab2').toggleClass('active')
        stepGlobal++
        jQuery('li.previous > button').toggleClass('d-none')
        jQuery('#nextStep').html('Agregar pregunta a encuesta')
      } else if (stepGlobal == 2) {
        if (
          jQuery('#' + jQuery('#selector_de_tipo').val() + ' > form:valid')
            .length
        ) {
          jQuery('#' + selected + ' > form').submit()
        } else {
          jQuery(
            '#' + jQuery('#selector_de_tipo').val() + ' > form:invalid',
          ).addClass('was-validated')
        }
      }
      e.preventDefault()
    })
  }
  return {
    init: init,
    initSeleccionMultiple: initSeleccionMultiple,
    eliminarOpcion: eliminarOpcion,
    sm_guardarOpcion: sm_guardarOpcion,
    sm_editarOpcion: sm_editarOpcion,
    ssj_guardarOpcion: ssj_guardarOpcion,
    ssj_editarOpcion: ssj_editarOpcion,
    ssj_agg_otro: ssj_agg_otro,
    initSeleccionJustificacion: initSeleccionJustificacion,
    smj_agg_otro: smj_agg_otro,
    smj_editarOpcion: smj_editarOpcion,
    smj_guardarOpcion: smj_guardarOpcion,
    initSeleccionMultipleJustificacion: initSeleccionMultipleJustificacion,
    ss_editarOpcion: ss_editarOpcion,
    ss_guardarOpcion: ss_guardarOpcion,
    initSeleccionSimple: initSeleccionSimple,
  }
})()
