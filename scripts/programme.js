
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
    b(9, "Arrival", "", types._GENERAL),
    b(19, "Dinner", "Buffet", types._FOOD),
    b(20.5, "Break", "", types._BREAK),
    b(21, "Opening", types._GENERAL),
    b(21.5, "Welcome party", "Welcome Party", types._PARTY)
  ],
  [
      b(8, "Breakfast", "", types._FOOD),
      b(9, "Opening lecture", "", types._GLECTURE),
      b(11, "Break", "", types._BREAK),
      b(11.5, "Student lectures", "", types._SLECTURE),
      b(12.5, "Guest lecture", "", types._GLECTURE),
      b(13.5, "City tour Utrecht/AGM", "Including lunch. Parallel: annual general meeting of IAPS", types._EXTERNAL),
      b(19, "Dinner", "In town", types._FOOD),
      b(21, "Break", "", types._BREAK),
      b(21.5, "Costume party", "Costume party", types._PARTY)
  ],
  [
      b(8, "Breakfast", "", types._FOOD),
      b(9, "Student lectures", "", types._SLECTURE),
      b(11, "Break", "", types._BREAK),
      b(11.5, "Guest lecture", "", types._GLECTURE),
      b(12.5, "Lunch", "Accompanied by company info stands", types._FOOD),
      b(14, "Guest lecture", "", types._GLECTURE),
      b(15, "IAPS workshop", "", types._GENERAL),
      b(16, "Student lectures", "", types._SLECTURE),
      b(17.5, "Poster session", "with drinks", types._POSTER),
      b(19, "Dinner", "", types._FOOD),
      b(21, "Free night", "", types._NONE)
  ],
  [
      b(8, "Breakfast", "", types._FOOD),
      b(9, "Transit to Twente", "", types.GENERAL),
      b(11, "Reception", "", types._GENERAL),
      b(11.5, "Opening (rector)", "", types._GENERAL),
      b(12, "Guest lecture", "", types._GLECTURE),
      b(13, "Lunch", "", types._FOOD),
      b(14, "Lab tours", "", types._EXTERNAL),
      b(16.5, "Break", "", types._BREAK),
      b(17, "Student lectures", "", types._SLECTURE),
      b(19, "Dinner", "Barbecue", types._FOOD),
      b(20.5, "Science Quiz", "", types._BREAK),
      b(21.5, "Dutch party", "Dutch party (continuously available transit back to Utrecht)", types._PARTY)
  ],
  [
      b(8, "Breakfast", "", types._FOOD),
      b(9, "Educational excursions", "", types._EXTERNAL),
      b(13, "Lunch", "", types._FOOD),
      b(14, "Cultural excursions", "", types._EXTERNAL),
      b(19, "Dinner", "", types._FOOD),
      b(21, "Break", "", types._BREAK),
      b(21.5, "Nations party", "", types._PARTY)
  ],
  [
      b(8, "Breakfast", "", types._FOOD),
      b(9, "Student lectures", "", types._SLECTURE),
      b(11, "Break", "", types._BREAK),
      b(11.5,"Guest lecture", "", types._GLECTURE),
      b(13, "Lunch", "", types._FOOD),
      b(14, "Student lectures", "", types._SLECTURE),
      b(17, "Break", "", types._BREAK),
      b(17.5, "Guest lecture", "", types._GLECTURE),
      b(18.5, "Closing", "", types._GENERAL),
      b(19, "Dinner", "", types._FOOD),
      b(21, "Break", "", types._BREAK),
      b(21.5, "Farewell party", "Farewell party", types._PARTY)
  ],
  [
      b(8, "Breakfast", "", types._FOOD),
      b(9, "Farewell", "", types._NONE),
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

    $.each(day.slice(0, day.length), function(index, el) {
      var start_fit = fit(el.start);

      var next_fit = 0;
      if(index < day.length - 1) { 
        next_fit = fit(day[index + 1].start);  
      } else {
        next_fit = fit(24); 
      }

      var height = Math.floor((next_fit - start_fit) * timetable.height());

      $('<div>'+el.title+'</div>').addClass('timeslot').addClass('slot-type-'+el.type).css('height', height+'px').appendTo('#programme-timetable div.day-column:nth-of-type('+div_index+')');
    });
  })
});
