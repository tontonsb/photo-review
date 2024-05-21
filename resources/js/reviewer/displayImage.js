import ImageLayer from 'ol/layer/Image.js'
import TileLayer from 'ol/layer/Tile.js'
import Map from 'ol/Map.js'
import Projection from 'ol/proj/Projection.js'
import Static from 'ol/source/ImageStatic.js'
import View from 'ol/View.js'
import {getCenter} from 'ol/extent.js'
import { XYZ } from 'ol/source'


export default function displayImage(target, width, height, url) {
    const extent = [0, 0, width, height]
    const projection = new Projection({
        code: 'this-image',
        units: 'pixels',
        extent: extent,
    })

    return new Map({
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
            zoom: 1,
        }),
    })
}


