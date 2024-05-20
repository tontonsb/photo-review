export default function bootInfobox(boxSelector, launcherSelector, show) {
    const infobox = document.querySelector(boxSelector)

    infobox.querySelectorAll('.js-close').forEach(
        button => button.addEventListener('click', _ => infobox.close())
    )

    document.querySelectorAll(launcherSelector).forEach(
        button => button.addEventListener('click', _ => infobox.showModal())
    )

    if (show)
        infobox.showModal()
}
