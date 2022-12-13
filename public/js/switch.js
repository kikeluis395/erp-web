var refresh_switchs = null
function eval_check(val) {
     if (val) return '1'
     return '0'
}

$(function () {
     const codes = { 1: 'SI', 0: 'NO' }
     $('.ventas_apli').each(function () {
          $(this).on('change', function (e) {
               var checked = e.target.checked
               const label = this.getAttribute('data-label')
               $(`#${label}`).text(codes[eval_check(checked)])
          })
     })

     refresh_switchs = function refresh_switchs() {
          $('.switch_label').each(function () {
               $(this).on('change', function (e) {
                    var checked = e.target.checked
                    var text_checked = this.getAttribute('data-text-checked')
                    var text_unchecked = this.getAttribute('data-text-unchecked')

                    const label = this.getAttribute('data-label')

                    var codified = { 1: text_checked ? text_checked : '', 0: text_unchecked ? text_unchecked : '' }

                    $(`#${label}`).text(codified[eval_check(checked)])
               })
          })
     }
     refresh_switchs()

     $('.create_switch_element').each(function () {
          var unique = Math.random().toString(36).substr(2, 6)
          var label_text = this.getAttribute('label-text')
          var input_name = this.getAttribute('input-name')
          var checked = this.getAttribute('checked') != null
          var addClass = this.getAttribute('data-class')
          var customCol = this.getAttribute('custom-col')
          var customPosition = this.getAttribute('custom-position')

          var text_checked = this.getAttribute('data-text-checked')
          var text_unchecked = this.getAttribute('data-text-unchecked')

          const label = document.createElement('label')
          const div = document.createElement('div')
          const input = document.createElement('input')
          const text = document.createElement('label')

          this.className = 'form-group form-inline create_switch_element'
          label.className = `col-sm-${customCol ? customCol : 6} justify-content-${
               customPosition ? customPosition : 'end'
          }`
          label.innerHTML = `${label_text}:`
          div.className = 'pl-5 custom-control custom-switch'
          input.className = 'custom-control-input col-6 switch_label'
          if (addClass) input.className += ` ${addClass}`

          input.setAttribute('type', 'checkbox')
          input.setAttribute('name', input_name)
          input.setAttribute('id', `input_${unique}`)
          input.setAttribute('data-label', `label_${unique}`)
          input.setAttribute('data-text-checked', text_checked)
          input.setAttribute('data-text-unchecked', text_unchecked)
          input.checked = checked

          text.className = 'custom-control-label col-12'
          text.setAttribute('for', `input_${unique}`)
          text.setAttribute('id', `label_${unique}`)
          text.innerHTML = checked ? text_checked : text_unchecked

          div.append(input)
          div.append(text)

          this.append(label)
          this.append(div)

          refresh_switchs()
     })
})
