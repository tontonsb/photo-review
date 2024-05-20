const timeStarted = new Date()
const form = document.querySelector('form')
const timeInput = form.querySelector('[name=reviewing_duration_ms]')
form.addEventListener('submit', () => timeInput.value = (new Date()) - timeStarted)
