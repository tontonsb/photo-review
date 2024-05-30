
import { Feature } from 'ol'
import { Point } from 'ol/geom'
import VectorLayer from 'ol/layer/Vector'
import VectorSource from 'ol/source/Vector'
import Circle from 'ol/style/Circle'
import Fill from 'ol/style/Fill'
import Stroke from 'ol/style/Stroke'
import Style from 'ol/style/Style'

export default function initUserMarkers() {
    const source = new VectorSource()

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

    const clickHandler = async event => {
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
    }

    const getMarkers = () => source.getFeatures().map(
        feature => feature.getGeometry().getCoordinates()
    )

    const addMarkers = markers => markers.forEach(
        marker => source.addFeature(
            new Feature(new Point(marker))
        )
    )

    return {layer, clickHandler, getMarkers, addMarkers}
}
