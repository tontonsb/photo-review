
import { Feature } from 'ol'
import { Control } from 'ol/control'
import { Point } from 'ol/geom'
import VectorLayer from 'ol/layer/Vector'
import VectorSource from 'ol/source/Vector'
import Circle from 'ol/style/Circle'
import Fill from 'ol/style/Fill'
import Stroke from 'ol/style/Stroke'
import Style from 'ol/style/Style'

function createClearControl() {
    const button = document.createElement('button')
    button.innerHTML = 'Noņemt visus marķierus'
    button.style.width = 'unset'
    button.style.fontWeight = 'unset'

    const element = document.createElement('div')
    element.className = 'ol-unselectable ol-control'
    element.style.right = '.5em'
    element.style.bottom = '.5em'
    element.style.display = 'none'
    element.appendChild(button)

    const control = new Control({element})

    return {button, element, control}
}

export default function initUserMarkers() {
    const source = new VectorSource()

    const clearControl = createClearControl()

    const layer = new VectorLayer({
        source: source,
        style: new Style({
            image: new Circle({
                radius: 15,
                fill: new Fill({
                    color: '#ff33e022',
                }),
                stroke: new Stroke({
                    color: '#ff33e0',
                    width: 2,
                }),
            }),
        }),
    })

    const removeClicked = async event => {
        const features = await layer.getFeatures(event.pixel)

        // If a feature was clicked, we remove it
        if (features.length) {
            features.forEach(
                feature => source.removeFeature(feature)
            )

            return
        }

        source.addFeature(
            new Feature(new Point(event.coordinate))
        )

        clearControl.element.style.display = 'block'
    }

    const getClickedFeatures = async event => {
        const features = await layer.getFeatures(event.pixel)

        return features
    }

    const getMarkers = () => source.getFeatures().map(
        feature => feature.getGeometry().getCoordinates()
    )

    const addMarkers = markers => markers.forEach(
        marker => source.addFeature(
            new Feature(new Point(marker))
        )
    )

    clearControl.button.addEventListener('click', () => {
        source.clear(true)
        clearControl.element.style.display = 'none'
    })

    return {layer, removeClicked, getClickedFeatures, getMarkers, addMarkers, clearControl: clearControl.control}
}
