import { default as deepEquals } from 'fast-deep-equal'
import { Calendar } from '@fullcalendar/core'
import resourceTimelinePlugin from '@fullcalendar/resource-timeline'
import { getFirstDateEl } from 'fullcalendar/tests/automated/lib/ViewUtils'
import { getTimelineResourceIds } from '../lib/timeline'

function buildOptions() {
  return {
    plugins: [ resourceTimelinePlugin ],
    defaultView: 'resourceTimelineDay',
    defaultDate: '2019-04-01',
    resources: [
      { id: 'a', title: 'Resource A' },
      { id: 'b', title: 'Resource B' }
    ]
  }
}

describe('mutateOptions', function() {
  let $calendarEl
  let calendar

  function mutateOptions(updates) {
    calendar.mutateOptions(updates, [], false, deepEquals)
  }

  beforeEach(function() {
    $calendarEl = $('<div>').appendTo('body')
  })

  afterEach(function() {
    if (calendar) { calendar.destroy() }
    $calendarEl.remove()
  })

  it('will rerender resoures without rerender the view', function() {
    calendar = new Calendar($calendarEl[0], buildOptions())
    calendar.render()
    let dateEl = getFirstDateEl()

    mutateOptions({
      resources: [
        { id: 'a', title: 'Resource A' }
      ]
    })

    expect(getTimelineResourceIds()).toEqual([ 'a' ])
    expect(getFirstDateEl()).toBe(dateEl)
  })

})
