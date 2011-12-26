var types = {
    _GENERAL: 0,
    _FOOD: 1,
    _GLECTURE: 2,
    _SLECTURE: 3,
    _BREAK: 4,
    _EXTERNAL: 5,
    _PARTY: 6,
    _POSTER: 7,
    _NONE: 99
 };

function b(start, title, sub, type) {
  return {"start": start, "title": title, "sub": sub, "type": type};
}

var schedule = [
  [
      b(8, "", "", types._NONE),
    b(14.5, "Arrival", "", types._GENERAL),
    b(18.5, "Dinner", "Buffet", types._FOOD),
    b(20.5, "Break", "", types._BREAK),
    b(21, "Party", "Welcome Party", types._PARTY)
  ],
  [
      b(8, "Breakfast", "", types._FOOD),
      b(9.25, "Opening lecture", "", types._GLECTURE),
      b(11, "Break", "", types._BREAK),
      b(11.5, "Student lectures", "", types._SLECTURE),
      b(13, "City tour Utrecht", "Including lunch. Parallel session: annual general meeting of IAPS", types._EXTERNAL),
      b(18.5, "Dinner", "In town", types._FOOD),
      b(20.5, "Break", "", types._BREAK),
      b(21, "Party", "Costume party", types._PARTY)
  ],
  [
      b(8, "Breakfast", "", types._FOOD),
      b(9.25, "Student lectures", "", types._SLECTURE),
      b(11, "Break", "", types._BREAK),
      b(11.5, "Guest lecture", "", types._GLECTURE),
      b(12.5, "Lunch", "Accompanied by company info stands", types._FOOD),
      b(14, "Guest lecture", "", types._GLECTURE),
      b(15, "IAPS workshop", "", types._GENERAL),
      b(15.5, "Student lectures", "", types._SLECTURE),
      b(16.5, "Poster session", "with drinks", types._POSTER),
      b(18.5, "Dinner", "", types._FOOD),
      b(20.5, "Free night", "", types._NONE)
  ],
  [
      b(8, "Breakfast", "and transit to Twente", types._FOOD),
      b(11, "Reception", "", types._GENERAL),
      b(11.5, "Opening (headmaster) and guest lecture", "", types._GLECTURE),
      b(13, "Lunch", "", types._FOOD),
      b(14, "Open labs and tours", "", types._EXTERNAL),
      b(16.5, "Break", "", types._BREAK),
      b(17.5, "Student lectures", "", types._SLECTURE),
      b(18.5, "Dinner", "", types._FOOD),
      b(20.5, "Break", "", types._BREAK),
      b(21, "Party", "Dutch party (continuously available transit back to Utrecht)", types._PARTY)
  ],
  [
      b(8, "Breakfast", "", types._FOOD),
      b(9.25, "Educational excursions", "", types._EXTERNAL),
      b(13, "Lunch", "", types._FOOD),
      b(14, "Cultural excursions", "", types._EXTERNAL),
      b(18.5, "Dinner", "", types._FOOD),
      b(20.5, "Break", "", types._BREAK),
      b(21, "Party", "Nations party", types._PARTY)
  ],
  [
      b(8, "Breakfast", "", types._FOOD),
      b(9.25, "Student lectures", "", types._SLECTURE),
      b(11, "Break", "", types._BREAK),
      b(13, "Lunch", "", types._FOOD),
      b(14, "Guest lecture", "", types._GLECTURE),
      b(15, "Student lectures", "", types._SLECTURE),
      b(17, "Formal closing", "", types._GENERAL),
      b(18.5, "Dinner", "", types._FOOD),
      b(20.5, "Break", "", types._BREAK),
      b(21, "Party", "Farewell party", types._PARTY)
  ],
  [
      b(8, "Breakfast", "", types._FOOD),
      b(9.25, "Farewell", "", types._NONE),
      b(12, "", "", types._NONE)
  ],

];

function fit(start) {
  return (start - 8) / 16;
}

$(function() {
  var timetable = $('#programme-timetable');
  
  $.each(schedule, function(s_index, day) {
    var div_index = s_index + 2;

    $.each(day.slice(0, day.length - 1), function(index, el) {
      var start_fit = fit(el.start);

      var next_fit = fit(day[index + 1].start);

      var height = Math.floor((next_fit - start_fit) * timetable.height());
      $('<div>'+el.title+'</div>').addClass('timeslot').css('height', height+'px').appendTo('#programme-timetable div.day-column:nth-of-type('+div_index+')');
    });
  })
});
