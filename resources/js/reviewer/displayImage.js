import ImageLayer from 'ol/layer/Image'
import Map from 'ol/Map'
import Projection from 'ol/proj/Projection'
import Static from 'ol/source/ImageStatic'
import View from 'ol/View'
import {getCenter} from 'ol/extent'

export default function displayImage(target, width, height, url) {
    const extent = [0, 0, width, height]
    const projection = new Projection({
        code: 'this-image',
        units: 'pixels',
        extent: extent,
    })

    const map = new Map({
        layers: [
            new ImageLayer({
                source: new Static({
                    url: url,
                    projection: projection,
                    imageExtent: extent,
                }),
            }),
        ],
        target: target,
        view: new View({
            projection: projection,
            center: getCenter(extent),
            extent: extent,
            showFullExtent: true,
            zoom: 1,
        }),
    })

    map.getView().fit(extent)

    return map
}


