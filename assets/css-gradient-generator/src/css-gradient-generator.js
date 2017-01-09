
var CSSGradientEditor = function(container, options) {
  'use strict';

  if (typeof console === 'undefined' || typeof console.log === 'undefined') {
    console = {};
    console.log = function() {
    };
  }

  var LAYOUT_SIMPLE = 0,
      LAYOUT_ADVANCED = 1,
      LAYOUT_EXPERT = 2;

  var MIN = -3000,
      MAX = 3000,
      _throttleDelay = 100,
      _scrollThrottleTimer = null,
      _lastScrollHandlerRun = 0,
      colorStops = [],
      undoArray = [],
      undoIndex = -1,
      undoTimeout = false,
      lastSelectedColor = '#c30000',
      lastunit = '%',
      colorStopIndex = 0,
      stopPointDragTarget = false,
      resizeHandlerInDrag = false,
      hueSliderInMove = false,
      chromaSliderInMove = false,
      lightnessSliderInMove = false,
      colorAdjustVisible = false,
      previewheightbeforestickiness = false,
      buggyfixed = false,
      popoutstate = false,
      coloradjust_popover_container,
      angleInMove = false,
      _selectedStopIndex = -1,
      swatches = [],
      currentgradient,
      qrcode,
      qrupdatetimeout,
      cssoutput = '',
      gradientready = false,
      layout,
      checkiflayoutcanchange = false,
      supportedrendermodes = {
        noprefix: false,
        svg: false,
        oldwebkit: false,
        filter: false
      },
  gradientAutosave = false,
      coloroffset = {
        hue: 0,
        saturation: 0,
        lightness: 0
      },
  elements = {
    markersarea: $('.css-gradient-editor-stoppointmarkers', container),
    gradientstopeditor: $('.css-gradient-editor-stopeditor span', container),
    anglecontroller: $('.css-gradient-editor-controller.css-gradient-editor-direction-angle', container),
    angleline: $('.css-gradient-editor-controller.css-gradient-editor-direction-angle span', container),
    angleinput: $('span.css-gradient-editor-direction-angle-input input', container),
    previewcontainer: $('.css-gradient-editor-preview-container', container),
    previewarea: $('.css-gradient-editor-preview', container),
    preview: $('.css-gradient-editor-preview div', container),
    previewpopoutbutton: $('.css-gradient-editor-previewpopout', container),
    previewpopoutoverlaybutton: $('.css-gradient-controls .css-gradient-editor-previewpopout', container),
    colorstopslist: $('.css-gradient-editor-stoppointlist', container),
    cssoutput: $('.css-gradient-editor-cssoutput', container),
    exportallmodal: $('#exportallmodal'),
    exportalltextarea: $('.css-gradient-editor-textarea-exportall'),
    importmodal: $('#importmodal'),
    configmodal: $('#configmodal'),
    importtextarea: $('.css-gradient-editor-textarea-import'),
    permalink: $('.css-gradient-editor-permalink', container),
    imagegradient: $('.css-gradient-editor-imagegradient', container),
    currentpreset: $('.css-gradient-editor-preset.current span', container),
    actualswatch: false,
    swatchescontainer: $('.css-gradient-editor-swatches', container),
    swatches: $('.css-gradient-editor-swatches ul', container),
    swatches_add: $('.css-gradient-editor-save', container),
    swatches_remove: $('.css-gradient-editor-delete', container),
    resizehandler: $('.css-gradient-editor-preview-resize-handler', container),
    adjust_color: $('.css-gradient-editor-adjustcolor', container),
    get_css: $('.css-gradient-editor-getcss', container),
    coloroffsethue: false,
    coloroffsetchroma: false,
    colorofsetlightness: false,
    undobutton: $('.css-gradient-editor-undo', container),
    redobutton: $('.css-gradient-editor-redo', container),
    addstoppointbutton: $('.css-gradient-editor-add-stoppoint', container),
    reorderstoppointsbutton: $('.css-gradient-editor-reorder-stoppoints', container),
    gradientpreferenceseasy: $('.gradient-preferences-easy', container),
    gradientpreferencesadvanced: $('.gradient-preferences-advanced', container),
    inputfrom: $('input[name=color_from]', container),
    inputto: $('input[name=color_to]', container),
    layoutselectoreasy: $('.css-gradient-editor-layout-easy'),
    layoutselectoradvanced: $('.css-gradient-editor-layout-advanced'),
    layoutselectorexpert: $('.css-gradient-editor-layout-expert'),
    warningadvanced: $('.layout-warning-advanced'),
    warningexpert: $('.layout-warning-expert'),
    loaddefaults: $('.loaddefaults', '#importmodal'),
    gradientpropertiespanel: $('.panel.gradient-properties', container)
  },
  settings = $.extend({
    customswatchesnameprefix: 'cssgradienteditor',
    defaultswatches: [
      't=linear,d=bottom+right,r=on|00c4f4/0/%,036078/100/%',
      't=linear,d=bottom+right,r=on|fe9e96/0/%,ac4f73/100/%',
      't=radial,s=farthest-corner,r=off,sh=ellipse,h=left,v=top|676767/1.1/%,878787/65.8/%,676767/100/%',
      't=linear,d=bottom+right,r=off|f949b6/0/%,ff8b8b/100/%',
      't=radial,s=farthest-corner,r=on,sh=ellipse,h=left,v=bottom|f3ef15/0/%,009885/100/%',
      't=linear,d=bottom,r=on|e2e2e2/0/%,dbdbdb/50/%,d1d1d1/51/%,fefefe/100/%',
      't=linear,d=bottom,r=on|accdd4/0/%,189ab1/50/%,087b95/51/%,70c0d1/100/%',
      't=linear,d=bottom,r=on|48556c/0/%,1b212b/50/%,141922/51/%,353b45/100/%',
      't=linear,d=bottom,r=on|808080/0/%,5b5b5b/65.6/%,a9a9a9/100/%',
      't=linear,d=bottom+right,r=on|000000/0/%,ffffff/100/%',
      't=linear,d=bottom+right,r=on|000000/0/%,00000000/100/%',
      't=radial,s=farthest-side,r=off,sh=circle,h=explicit,hv=395,hu=px,v=explicit,vv=483,vu=px|2200cf/0/%,ac00d7/74.2/%,8206ff/83.3/%',
      't=radial,s=explicit,sv=531,su=px,r=off,sh=circle,h=explicit,hv=59,hu=px,v=explicit,vv=147,vu=px|ffffff/0/%,e544c6/70/%,047694/100/%',
      't=radial,s=farthest-side,r=off,sh=ellipse,h=center,v=center|535b5e/0/%,fefefe/25/%,4a5154/50/%,fdfdfd/75/%,535b5e/100/%',
      't=linear,d=bottom+right,r=on|00a5df/0/%,3e147b/20/%,e20079/40/%,df132c/60/%,f3ef15/80/%,009847/100/%',
      't=linear,d=bottom+right,r=on|00a5df/0/%,3e147b/6.6/%,e20079/13.2/%,df132c/18.8/%,f3ef15/24.1/%,009847/26.6/%',
      't=linear,d=bottom+right,r=on|535b5e/0/%,fefefe/25/%,4a5154/50/%,fdfdfd/75/%,535b5e/100/%',
      't=linear,d=bottom+right,r=on|000000/0/%,000000/9/%,00000000/10/%,00000000/19/%,000000/20/%,000000/29/%,00000000/30/%,00000000/39/%,000000/40/%,000000/49/%,00000000/50/%,00000000/59/%,000000/60/%,000000/69/%,00000000/70/%,00000000/79/%,000000/80/%,000000/89/%,00000000/90/%,00000000/100/%',
      't=linear,d=bottom+right,r=on|000000/0/%,000000/9/%,252525/9.1/%,252525/18/%,464646/18.1/%,464646/27/%,636363/27.1/%,636363/36/%,7d7d7d/36.1/%,7d7d7d/45/%,959595/45.1/%,959595/54/%,acacac/54.1/%,acacac/63/%,c2c2c2/63.1/%,c2c2c2/72/%,d7d7d7/72.1/%,d7d7d7/81/%,ebebeb/81.1/%,ebebeb/90/%,ffffff/90.1/%,ffffff/100/%',
      't=radial,s=explicit,sv=10,su=em,r=on,sh=circle,h=left,v=top|accdd4/0/%,189ab1/50/%,087b95/51/%,70c0d1/100/%',
      't=linear,d=angle,r=off,a=248|0001cdca/13.4/%,01cdca/14.5/%,015f9e/19.3/%,0001cdca/20.5/%'
    ],
    remove_distance: 50,
    positiondecimals: 1,
    gradient_type: 'linear',
    gradient_direction: 'bottom right',
    gradient_size: 'farthest-corner',
    gradient_size_value: '10',
    gradient_size_unit: 'px',
    gradient_size_major_value: '10',
    gradient_size_major_unit: 'px',
    gradient_repeat: 'off',
    gradient_shape: 'ellipse',
    linear_gradient_angle: '0',
    gradient_position_horizontal: 'left',
    gradient_position_horizontal_value: '0',
    gradient_position_horizontal_unit: '%',
    gradient_position_vertical: 'top',
    gradient_position_vertical_value: '0',
    gradient_position_vertical_unit: '%'
  }, options),
      shorteningdata = {
        gradient_type: 't',
        gradient_direction: 'd',
        gradient_size: 's',
        gradient_size_value: 'sv',
        gradient_size_unit: 'su',
        gradient_size_major_value: 'smv',
        gradient_size_major_unit: 'smu',
        gradient_repeat: 'r',
        gradient_shape: 'sh',
        linear_gradient_angle: 'a',
        gradient_position_horizontal: 'h',
        gradient_position_horizontal_value: 'hv',
        gradient_position_horizontal_unit: 'hu',
        gradient_position_vertical: 'v',
        gradient_position_vertical_value: 'vv',
        gradient_position_vertical_unit: 'vu'
      },
  defaultconfig = {
    config_layout: LAYOUT_ADVANCED,
    config_colorformat: 'rgb',
    config_colorpicker_hsl: true,
    config_colorpicker_rgb: true,
    config_colorpicker_cie: false,
    config_colorpicker_opacity: true,
    config_colorpicker_swatches: false,
    config_fallbackwidth: '',
    config_fallbackheight: '',
    config_mixedstoppointunits: 'enabled',
    config_generation_bgcolor: true,
    config_generation_iefilter: true,
    config_generation_svg: true,
    config_generation_oldwebkit: true,
    config_generation_webkit: true,
    config_generation_ms: true,
    config_cssselector: '.gradient-color'
  };

  restorePreviewSize();

  init();
  setupLayout();

  initUndo();

  gradientAutosave = true;

  refreshUndoButtons();

  function initSupportedRenderModes() {
    supportedrendermodes.css = $.fn.ColorPickerSliders.detectWhichGradientIsSupported();
    if ($.fn.ColorPickerSliders.svgSupported()) {
      supportedrendermodes.svg = true;
    }
  }

  function getCurrentRendermode() {
    if (supportedrendermodes.css) {
      if (supportedrendermodes.css === 'filter' && supportedrendermodes.svg) {
        return 'svg';
      }
      else {
        return supportedrendermodes.css;
      }
    }
    else if (supportedrendermodes.svg) {
      return 'svg';
    }
    else {
      return 'averagebgcolor';
    }
  }

  function saveInputPreference(input) {
    var name = input.attr('name');
    setPreference(name + '_value', input.val());
    setPreference(name + '_unit', input.next('.bootstrap-touchspin-postfix').text());
  }

  function getDegreeFromDistance(xd, yd) {
    if (yd >= 0) {
      return Math.atan2(yd, xd) * 180 / Math.PI;
    }
    else {
      return 360 + Math.atan2(yd, xd) * 180 / Math.PI;
    }
  }

  function init() {
    $('[title]').tooltip({
      animation: false,
      html: true
    });

    initSupportedRenderModes();

    if (window.location.search.length) {
      initData(window.location.search.substring(1));  // compatibility with the older urls
    }
    else if (getConfig('lastGradient')) {
      initData(getConfig('lastGradient'));
    }
    else {
      initData('t=linear,d=bottom,r=on|c5e3ef/0/%,4badd2/50/%,278fba/51/%,8ed4f1/100/%');
    }

    initConfigValues();
    bindConfigEvents();
    bindevents();

    $('input[name="angle"]').val(getPreference('linear_gradient_angle')).TouchSpin({
      postfix: '<sup>o</sup>',
      min: 0,
      max: 359
    }).on('change touchspin.on.stopspin', function(ev) {
      setPreference('linear_gradient_angle', $(this).val() % 360);
      $(this).closest('.css-gradient-editor-controller').trigger('mousedown');
      renderAngle(false);
      renderGradient();

      if (ev.type === 'touchspin') {
        undoSaveState();
      }
    });

    $('input[name="gradient_size"]').val(getPreference('gradient_size_value')).TouchSpin({
      postfix: getPreference('gradient_size_unit'),
      min: 0,
      max: MAX
    }).on('change touchspin.on.stopspin', function(ev) {
      saveInputPreference($(this));
      if (ev.type === 'touchspin') {
        undoSaveState();
      }
    });

    $('input[name="gradient_size_major"]').val(getPreference('gradient_size_major_value')).TouchSpin({
      postfix: getPreference('gradient_size_major_unit'),
      min: 0,
      max: MAX
    }).on('change touchspin.on.stopspin', function(ev) {
      saveInputPreference($(this));
      if (ev.type === 'touchspin') {
        undoSaveState();
      }
    });

    $('input[name="gradient_position_horizontal"]').val(getPreference('gradient_position_horizontal_value')).TouchSpin({
      postfix: getPreference('gradient_position_horizontal_unit'),
      min: MIN,
      max: MAX
    }).on('change touchspin.on.stopspin', function(ev) {
      saveInputPreference($(this));
      if (ev.type === 'touchspin') {
        undoSaveState();
      }
    });

    $('input[name="gradient_position_vertical"]').val(getPreference('gradient_position_vertical_value')).TouchSpin({
      postfix: getPreference('gradient_position_vertical_unit'),
      min: MIN,
      max: MAX
    }).on('change touchspin.on.stopspin', function(ev) {
      saveInputPreference($(this));
      if (ev.type === 'touchspin') {
        undoSaveState();
      }
    });

    updatePreferencesVisibility();

    renderSwatches();

    renderAll(true);    // calls undoSaveState when ready

    elements.preview.removeClass('ajax-loader');

    initQR();
  }

  function setupLayout() {
    var layoutneededforgradient = detectCompatibilityLevel(parseGradientPermalink(currentgradient));

    layout = getConfig('config_layout');

    elements.layoutselectoreasy.removeClass('active');
    elements.layoutselectoradvanced.removeClass('active');
    elements.layoutselectorexpert.removeClass('active');

    switch (layout) {
      case LAYOUT_SIMPLE:
        {
          elements.layoutselectoreasy.addClass('active');
          break;
        }
      case LAYOUT_ADVANCED:
        {
          elements.layoutselectoradvanced.addClass('active');
          break;
        }
      case LAYOUT_EXPERT:
        {
          elements.layoutselectorexpert.addClass('active');
          break;
        }
    }

    checkiflayoutcanchange = false;

    if (layoutneededforgradient > layout) {
      checkiflayoutcanchange = true;
      if (layoutneededforgradient === LAYOUT_ADVANCED) {
        if (!elements.warningadvanced.is(':visible')) {
          elements.warningexpert.hide();
          elements.warningadvanced.show();
        }
      }
      else {
        if (!elements.warningexpert.is(':visible')) {
          elements.warningadvanced.hide();
          elements.warningexpert.show();
        }
      }

      layout = layoutneededforgradient;
    }
    else {
      if (elements.warningadvanced.is(':visible')) {
        elements.warningadvanced.hide();
      }
      if (elements.warningexpert.is(':visible')) {
        elements.warningexpert.hide();
      }
    }

    var nowchanged = false;

    switch (layout) {
      case LAYOUT_SIMPLE:
        if (!container.hasClass('layout-simple')) {
          nowchanged = true;
          container.removeClass('layout-advanced layout-expert');
          container.addClass('layout-simple');
        }
        break;
      case LAYOUT_ADVANCED:
        if (!container.hasClass('layout-advanced')) {
          nowchanged = true;
          container.removeClass('layout-simple layout-expert');
          container.addClass('layout-advanced');
        }
        break;
      case LAYOUT_EXPERT:
        if (!container.hasClass('layout-expert')) {
          nowchanged = true;
          container.removeClass('layout-simple layout-advanced');
          container.addClass('layout-expert');
        }
        break;
    }

    if (nowchanged) {
      renderAll();
    }
  }

  function updateInputValues() {
    $('input[name="gradient_size"]').val(getPreference('gradient_size_value'));
    $('input[name="gradient_size_major"]').val(getPreference('gradient_size_major_value'));
    $('input[name="gradient_position_horizontal"]').val(getPreference('gradient_position_horizontal_value'));
    $('input[name="gradient_position_vertical"]').val(getPreference('gradient_position_vertical_value'));

    changeUnit($('input[name="gradient_size"]').next('.input-group-addon.bootstrap-touchspin-postfix'), getPreference('gradient_size_unit'));
    changeUnit($('input[name="gradient_size_major"]').next('.input-group-addon.bootstrap-touchspin-postfix'), getPreference('gradient_size_major_unit'));
    changeUnit($('input[name="gradient_position_horizontal"]').next('.input-group-addon.bootstrap-touchspin-postfix'), getPreference('gradient_position_horizontal_unit'));
    changeUnit($('input[name="gradient_position_vertical"]').next('.input-group-addon.bootstrap-touchspin-postfix'), getPreference('gradient_position_vertical_unit'));
  }

  function initOffsetPopover() {
    hueSliderInMove = false;
    chromaSliderInMove = false;
    lightnessSliderInMove = false;

    elements.coloroffsethue.css('left', 50 + 50 * (coloroffset.hue / 180) + '%');
    elements.coloroffsetchroma.css('left', 50 + 50 * (coloroffset.saturation / 100) + '%');
    elements.coloroffsetlightness.css('left', 50 + 50 * (coloroffset.lightness / 100) + '%');

    elements.coloroffsethue.tooltip({
      title: 'hue: ' + (coloroffset.hue > 0 ? '+' : '') + coloroffset.hue,
      animation: false,
      trigger: 'manual'
    });

    elements.coloroffsetchroma.tooltip({
      title: 'chroma: ' + (coloroffset.saturation > 0 ? '+' : '') + coloroffset.saturation,
      animation: false,
      trigger: 'manual'
    });

    elements.coloroffsetlightness.tooltip({
      title: 'lightness: ' + (coloroffset.lightness > 0 ? '+' : '') + coloroffset.lightness,
      animation: false,
      trigger: 'manual'
    });

    elements.coloroffsethue.on('touchstart mousedown', function(ev) {
      // enable for left click only
      if (ev.which > 1) {
        return;
      }

      hueSliderInMove = true;

      ev.stopPropagation();
      ev.preventDefault();
    });

    elements.coloroffsetchroma.on('touchstart mousedown', function(ev) {
      // enable for left click only
      if (ev.which > 1) {
        return;
      }

      chromaSliderInMove = true;

      ev.stopPropagation();
      ev.preventDefault();
    });

    elements.coloroffsetlightness.on('touchstart mousedown', function(ev) {
      // enable for left click only
      if (ev.which > 1) {
        return;
      }

      lightnessSliderInMove = true;

      ev.stopPropagation();
      ev.preventDefault();
    });

    elements.coloroffsethue.on('mouseover', function() {
      if (hueSliderInMove || chromaSliderInMove || lightnessSliderInMove) {
        return;
      }

      elements.coloroffsethue.tooltip('show');
    });

    elements.coloroffsethue.on('mouseout', function() {
      if (hueSliderInMove || chromaSliderInMove || lightnessSliderInMove) {
        return;
      }

      elements.coloroffsethue.tooltip('hide');
    });

    elements.coloroffsetchroma.on('mouseover', function() {
      if (hueSliderInMove || chromaSliderInMove || lightnessSliderInMove) {
        return;
      }

      elements.coloroffsetchroma.tooltip('show');
    });

    elements.coloroffsetchroma.on('mouseout', function() {
      if (hueSliderInMove || chromaSliderInMove || lightnessSliderInMove) {
        return;
      }

      elements.coloroffsetchroma.tooltip('hide');
    });

    elements.coloroffsetlightness.on('mouseover', function() {
      if (hueSliderInMove || chromaSliderInMove || lightnessSliderInMove) {
        return;
      }

      elements.coloroffsetlightness.tooltip('show');
    });

    elements.coloroffsetlightness.on('mouseout', function() {
      if (hueSliderInMove || chromaSliderInMove || lightnessSliderInMove) {
        return;
      }

      elements.coloroffsetlightness.tooltip('hide');
    });

    $(document).on('click', '.coloroffset-close', function() {
      _hideColorAdjust();
    });
  }

  function nullColorOffsets() {
    coloroffset = {
      hue: 0,
      saturation: 0,
      lightness: 0
    };

    if (colorStops.length === 0 || typeof colorStops[0].originalcolor === 'undefined') {
      return;
    }

    if (elements.hueoffset) {
      elements.hueoffset.val(0);
      elements.saturationoffset.val(0);
      elements.lightnessoffset.val(0);
    }

    for (var i = 0; i < colorStops.length; i++) {
      var cs = colorStops[i];

      delete cs.originalcolor;
    }

    elements.coloroffsethue.css('left', '50%');
    elements.coloroffsetchroma.css('left', '50%');
    elements.coloroffsetlightness.css('left', '50%');
  }

  function applyColorOffsets() {
    for (var i = 0; i < colorStops.length; i++) {
      var cs = colorStops[i],
          tiny,
          hsl,
          cielch;

      if (typeof cs.originalcolor === undefined || !cs.originalcolor) {
        cs.originalcolor = cs.color;
        tiny = tinycolor(cs.color);
      }
      else {
        tiny = tinycolor(cs.originalcolor);
      }

      hsl = tiny.toHsl();

      cielch = $.fn.ColorPickerSliders.rgb2lch(tiny.toRgb());

      cielch.h += coloroffset.hue;
      cielch.h = Math.abs(cielch.h + 360) % 360;

      cielch.c += coloroffset.saturation * 1.44;
      cielch.l += coloroffset.lightness * 1.01;

      if (cielch.c < 0) {
        cielch.c = 0;
      }

      if (cielch.l < 0) {
        cielch.l = 0;
      }

      hsl.h += coloroffset.hue;
      hsl.h = Math.abs(hsl.h + 360) % 360;

      hsl.s += coloroffset.saturation / 100;

      hsl.l += coloroffset.lightness / 100;

      if (hsl.s > 1) {
        hsl.s = 1;
      }

      if (hsl.s < 0) {
        hsl.s = 0;
      }

      if (hsl.l > 1) {
        hsl.l = 1;
      }

      if (hsl.l < 0) {
        hsl.l = 0;
      }

      cs.color = tinycolor($.fn.ColorPickerSliders.lch2rgb(cielch)).toRgbString();
    }
  }

  function getRenderColor(c) {
    var color;

    if (c.hasOwnProperty('color')) {
      color = c.color;
    }
    else {
      color = c;
    }

    switch (getConfig('config_colorformat')) {
      case 'hsl':
        return tinycolor(color).toHslString();

      case 'hex':
        var tc = tinycolor(color);

        if (tc.getAlpha() < 1) {
          return tinycolor(color).toRgbString();
        }

        return tinycolor(color).toHexString();

      default:
        return color;

    }
  }

  function getSvgStyle(stoppoint) {
    var color = tinycolor(stoppoint.color);

    return 'stop-color="' + color.toHexString() + '" stop-opacity="' + color.toRgb().a + '"';
  }

  function replaceAll(find, replace, str) {
    return str.replace(new RegExp(find, 'g'), replace);
  }

  function safeDecode(s) {
    var r;

    try {
      r = decodeURIComponent(s);
    }
    catch (e) {
      r = s;
    }

    return r.replace('+', ' ');
  }

  function parseGradientPermalink(data) {
    data = convertToNewGradientFormat(data);

    data = data.split('&sp=');

    if (!data instanceof Array) {
      return false;
    }

    if (data.length !== 2) {
      return false;
    }

    var extracteddata = {},
        colorStops = [],
        i;

    var querydata = data[0].split('&'),
        stoppointsdata = data[1].split('__');

    for (i = 0; i < querydata.length; i++) {
      data = querydata[i].split('=');
      extracteddata[getOriginalPreferenceName(data[0])] = safeDecode(data[1]);
    }

    for (i = 0; i < stoppointsdata.length; i++) {
      data = stoppointsdata[i].split('_');
      if (!data[0].length) {
        continue;
      }
      colorStops.push({
        color: tinycolor(safeDecode(data[0])).toRgbString(),
        position: safeDecode(data[1]),
        unit: safeDecode(data[2]),
        index: i,
        markforDeath: false
      });
    }

    return {
      data: extracteddata,
      colorStops: colorStops
    };
  }

  function initData(data) {
    var extracteddata = {},
        stoppointsdata = '',
        parsed;

    try {
      if (typeof (data) === 'undefined') {
        parsed = parseGradientPermalink(window.location.search.substring(1));

        extracteddata = parsed.data;
        stoppointsdata = parsed.colorStops;
      }
      else {
        parsed = parseGradientPermalink(data);

        extracteddata = parsed.data;
        stoppointsdata = parsed.colorStops;
      }
    } catch (e) {
    }

    if (typeof extracteddata === 'undefined') {
      extracteddata = {};
    }

    container.data({
      gradient_type: extracteddata.gradient_type || settings.gradient_type,
      gradient_direction: extracteddata.gradient_direction || settings.gradient_direction,
      gradient_size: extracteddata.gradient_size || settings.gradient_size,
      gradient_size_value: extracteddata.gradient_size_value || settings.gradient_size_value,
      gradient_size_unit: extracteddata.gradient_size_unit || settings.gradient_size_unit,
      gradient_size_major_value: extracteddata.gradient_size_major_value || settings.gradient_size_major_value,
      gradient_size_major_unit: extracteddata.gradient_size_major_unit || settings.gradient_size_major_unit,
      gradient_repeat: extracteddata.gradient_repeat || settings.gradient_repeat,
      gradient_shape: extracteddata.gradient_shape || settings.gradient_shape,
      linear_gradient_angle: extracteddata.linear_gradient_angle || settings.linear_gradient_angle,
      gradient_position_horizontal: extracteddata.gradient_position_horizontal || settings.gradient_position_horizontal,
      gradient_position_horizontal_value: extracteddata.gradient_position_horizontal_value || settings.gradient_position_horizontal_value,
      gradient_position_horizontal_unit: extracteddata.gradient_position_horizontal_unit || settings.gradient_position_horizontal_unit,
      gradient_position_vertical: extracteddata.gradient_position_vertical || settings.gradient_position_vertical,
      gradient_position_vertical_value: extracteddata.gradient_position_vertical_value || settings.gradient_position_vertical_value,
      gradient_position_vertical_unit: extracteddata.gradient_position_vertical_unit || settings.gradient_position_vertical_unit
    });

    initControllers();

    if (typeof stoppointsdata !== 'undefined' && stoppointsdata !== '') {
      for (var i = 0; i < stoppointsdata.length; i++) {
        addColorStop(stoppointsdata[i]);
      }
    }
  }

  function initControllers() {
    $('.css-gradient-editor-controller').each(function() {
      var $this = $(this);

      if ($this.data('name').indexOf('config_') === 0) {
        return;
      }

      if (container.data($this.data('name')) === $this.data('value')) {
        $this.addClass('active');
        $this.trigger('mousedown');
      }
      else {
        $this.removeClass('active');
      }
    });


  }

  function _showColorAdjust() {
    var el,
        popover_content;

    coloradjust_popover_container = $('<div class="coloroffset-popover-container"></div>').appendTo('body');

    popover_content = $('<div class="coloroffset-container"></div>').appendTo(coloradjust_popover_container);
    popover_content.html($('#coloroffsethtml').html());

    elements.coloroffsethue = $('.offset-hue.slider-container .slider-controller', popover_content);
    elements.coloroffsetchroma = $('.offset-chroma.slider-container .slider-controller', popover_content);
    elements.coloroffsetlightness = $('.offset-lightness.slider-container .slider-controller', popover_content);

    initOffsetPopover(el);

    elements.adjust_color.popover({
      html: true,
      animation: false,
      trigger: 'manual',
      title: 'Adjust gradient color <button type="button" class="close coloroffset-close pull-right" aria-hidden="true">×</button>',
      placement: 'top',
      container: coloradjust_popover_container,
      content: function() {
        return popover_content;
      }
    });

    elements.adjust_color.popover('show');
    colorAdjustVisible = true;

    var popover = $('.popover'),
        viewportwidth = $(window).width();

    if (viewportwidth < (popover.offset().left + popover.width())) {
      popover.css('left', viewportwidth - popover.width() - 5);
    }
  }

  function _hideColorAdjust() {
    try {
      elements.adjust_color.popover('destroy');
      coloradjust_popover_container.remove();
    }
    catch (e) {
    }

    colorAdjustVisible = false;
  }

  function resizePreview(ev) {
    var size = calculateEventPosition(ev, elements.previewarea),
        x = size.horizontal.pixel + resizeHandlerInDrag.xoffset,
        y = size.vertical.pixel + resizeHandlerInDrag.yoffset;

    if (!previewIsPopout()) {
      if (x < 30) {
        x = 30;
      }

      if (y < 30) {
        y = 30;
      }

      if (x > elements.previewcontainer.width()) {
        x = elements.previewcontainer.width();
      }

      if (y > 400) {
        y = 400;
      }

      setConfig('previewwidth', x);
      setConfig('previewheight', y);
    }
    else {
      if (x < 50) {
        x = 50;
      }

      if (y < 40) {
        y = 40;
      }

      if (x > $(window).width()) {
        x = $(window).width();
      }

      if (y > $(window).height()) {
        y = $(window).height();
      }

      setConfig('popoutpreviewwidth', x);
      setConfig('popoutpreviewheight', y);
    }

    elements.previewarea.css('width', x);
    elements.previewarea.css('height', y);

    if (getCurrentRendermode() === 'oldwebkit' || (getCurrentRendermode() === 'svg' && getPreference('gradient_size') === 'explicit' && getPreference('gradient_size_unit') !== '%')) {
      renderAll();
    }
  }

  function previewIsPopout() {
    return elements.previewpopoutbutton.hasClass('active');
  }

  function togglePreviewPopout() {
    if (previewIsPopout()) {
      hidePreviewPopout();
    }
    else {
      showPreviewPopout();
    }
  }

  function showPreviewPopout() {
    popoutstate = true;

    elements.previewpopoutbutton.addClass('active');
    elements.previewarea.addClass('preview-popout');

    elements.previewpopoutoverlaybutton.show();

    restorePreviewSize();

    if (getCurrentRendermode() === 'oldwebkit' || (getCurrentRendermode() === 'svg' && getPreference('gradient_size') === 'explicit' && getPreference('gradient_size_unit') !== '%')) {
      renderAll();
    }
  }

  function hidePreviewPopout() {
    popoutstate = false;

    elements.previewpopoutbutton.removeClass('active');
    elements.previewarea.removeClass('preview-popout');
    elements.previewpopoutbutton.blur();

    elements.previewpopoutoverlaybutton.hide();

    restorePreviewSize();

    handlePreviewStickyState();

    if (getCurrentRendermode() === 'oldwebkit' || (getCurrentRendermode() === 'svg' && getPreference('gradient_size') === 'explicit' && getPreference('gradient_size_unit') !== '%')) {
      renderAll();
    }
  }

  function handlePreviewStickyState() {
    if (popoutstate) {
      return;
    }

    var sticky = true,
        previewoffset = elements.previewcontainer.offset(),
        gradientpropertiesoffset = elements.gradientpropertiespanel.offset(),
        viewportheight = $(window).height(),
        gradientpropertiesbottom = elements.gradientpropertiespanel.height() + gradientpropertiesoffset.top;

    if (gradientpropertiesbottom - previewoffset.top < viewportheight) {
      sticky = false;
    }

    var scrolltop = $(document).scrollTop(),
        difference = scrolltop - previewoffset.top,
        maxheight = Math.round(viewportheight / 3);

    if (scrolltop + maxheight > gradientpropertiesbottom) {
      sticky = false;
    }

    if (difference < 0) {
      sticky = false;
    }

    if (sticky && (!elements.previewarea.hasClass('preview-sticky') || buggyfixed)) {
      if (previewheightbeforestickiness === false) {
        previewheightbeforestickiness = elements.previewarea.height();
        elements.previewcontainer.height(elements.previewarea.height());
        elements.previewarea.addClass('preview-sticky');
        elements.resizehandler.hide();
        //elements.previewcontainer.height(previewheightbeforestickiness);

        if (previewheightbeforestickiness > maxheight) {
          elements.previewarea.height(maxheight);
        }

        if (buggyfixed || elements.previewarea.offset().top < scrolltop) {
          buggyfixed = true;
          elements.previewarea.addClass('buggyfixed');
        }

        if (getCurrentRendermode() === 'oldwebkit' || (getCurrentRendermode() === 'svg' && getPreference('gradient_size') === 'explicit' && getPreference('gradient_size_unit') !== '%')) {
          renderAll();
        }
      }

      if (buggyfixed) {
        elements.previewarea.css('top', difference);
      }
    }
    else if (!sticky && elements.previewarea.hasClass('preview-sticky')) {
      if (previewheightbeforestickiness !== false) {
        elements.previewarea.removeClass('preview-sticky');
        elements.previewarea.css('top', 0);
        elements.resizehandler.show();
        elements.previewcontainer.height('auto');
        elements.previewarea.height(previewheightbeforestickiness);

        previewheightbeforestickiness = false;

        if (getCurrentRendermode() === 'oldwebkit' || (getCurrentRendermode() === 'svg' && getPreference('gradient_size') === 'explicit' && getPreference('gradient_size_unit') !== '%')) {
          renderAll();
        }
      }
    }
  }

  function updateStickyPreviewHeight() {
    if (previewheightbeforestickiness === false) {
      return;
    }

    var viewportheight = $(window).height(),
        maxheight = Math.round(viewportheight / 3);

    if (maxheight > previewheightbeforestickiness) {
      maxheight = previewheightbeforestickiness;
    }

    elements.previewarea.height(maxheight);
  }

  function restorePreviewSize() {
    if (elements.previewpopoutbutton.hasClass('active')) {
      var viewportwidth = $(window).width(),
          viewportheight = $(window).height(),
          width = getConfig('popoutpreviewwidth'),
          height = getConfig('popoutpreviewheight');

      if (typeof (width) === 'undefined') {
        width = 100;
      }

      if (typeof (height) === 'undefined') {
        height = 100;
      }

      if (width > viewportwidth) {
        width = viewportwidth;
      }

      if (height > viewportheight) {
        height = viewportheight;
      }

      elements.previewarea.width(width + 'px');
      elements.previewarea.height(height + 'px');
    }
    else {
      elements.previewarea.width(getConfig('previewwidth') || '100%');
      elements.previewarea.height(getConfig('previewheight') || '197px');
      elements.previewpopoutoverlaybutton.hide();
    }
  }

  function bindevents() {
    $('.modal-body').on('mousedown mouseup click contextmenu', function(e) {
      e.stopPropagation();
    });

    $('input[name=color_from], input[name=color_to]').on('contextmenu', function(e) {
      e.stopPropagation();
    });

    $(document).on('cssgradienteditor.changeswatches', function() {
      renderSwatches();
    });

    $(document).scroll(function() {
      if (new Date().getTime() - _lastScrollHandlerRun > _throttleDelay) {
        _lastScrollHandlerRun = new Date().getTime();
        handlePreviewStickyState();
      }
      else {
        clearTimeout(_scrollThrottleTimer);
        _scrollThrottleTimer = setTimeout(function() {
          _lastScrollHandlerRun = new Date().getTime();
          handlePreviewStickyState();
        }, _throttleDelay);
      }
    });

    $(document).on('click', '.force-layout-change', function(ev) {
      ev.preventDefault();
      ev.stopPropagation();

      forceLayoutChange();
    });

    elements.loaddefaults.on('click', function() {
      elements.importtextarea.val(JSON.stringify(settings.defaultswatches));
    });

    elements.layoutselectoreasy.on('click', function(ev) {
      setConfig('config_layout', LAYOUT_SIMPLE);
      ev.preventDefault();
      ev.stopPropagation();

      setupLayout();
    });

    elements.layoutselectoradvanced.on('click', function(ev) {
      setConfig('config_layout', LAYOUT_ADVANCED);
      ev.preventDefault();
      ev.stopPropagation();

      setupLayout();
    });

    elements.layoutselectorexpert.on('click', function(ev) {
      setConfig('config_layout', LAYOUT_EXPERT);
      ev.preventDefault();
      ev.stopPropagation();

      setupLayout();
    });

    elements.undobutton.on('click', function() {
      undoBack();
    });

    elements.redobutton.on('click', function() {
      undoForward();
    });

    elements.previewpopoutbutton.on('click', function() {
      togglePreviewPopout();
    });

    elements.adjust_color.on('click', function() {
      if (colorAdjustVisible) {
        _hideColorAdjust();
      }
      else {
        _showColorAdjust();
      }
    });

    elements.resizehandler.on('mousedown touchstart', function(ev) {
      resizeHandlerInDrag = true;

      var size = calculateEventPosition(ev, elements.previewarea);

      resizeHandlerInDrag = {
        xoffset: elements.previewarea.width() - size.horizontal.pixel,
        yoffset: elements.previewarea.height() - size.vertical.pixel
      };

      ev.stopPropagation();
      ev.preventDefault();
    });

    elements.markersarea.on('click', function(ev) {
      if (lastunit === '%') {
        addColorStop({
          position: calculateEventPosition(ev, $(this)).horizontal.percent,
          unit: lastunit,
          color: lastSelectedColor
        });
      }
      else {
        addColorStop({
          position: calculateEventPosition(ev, $(this)).horizontal.pixel,
          unit: lastunit,
          color: lastSelectedColor
        });
      }

      ev.stopPropagation();
      ev.preventDefault();

      renderAll();
      undoSaveState();
    });

    $(document).on('touchmove mousemove', function(ev) {
      if (!stopPointDragTarget) {
        return;
      }

      detectDeleteState(ev);
      moveDragTarget(calculateEventPosition(ev, elements.markersarea));

      ev.stopPropagation();
      ev.preventDefault();
    });

    $(document).on('touchmove mousemove', function(ev) {
      if (!resizeHandlerInDrag) {
        return;
      }

      resizePreview(ev);

      ev.stopPropagation();
      ev.preventDefault();
    });

    $(document).on('touchend mouseup', function(ev) {
      if (!!stopPointDragTarget) { // a drag was in progress
        if (stopPointDragTarget.data('mark-for-death')) {
          removeColorStop(stopPointDragTarget.data('index'));
        }

        stopPointDragTarget = false;

        undoSaveState();

        updateReorderButtonState();

        ev.stopPropagation();
        ev.preventDefault();
      }

      if (!!angleInMove) {
        angleInMove = false;

        undoSaveState();

        ev.stopPropagation();
        ev.preventDefault();
      }

      if (!!resizeHandlerInDrag) {
        resizeHandlerInDrag = false;
      }
    });

    elements.cssoutput.on('contextmenu', function(ev) {
      ev.stopPropagation();
    });

    elements.permalink.on('contextmenu', function(ev) {
      ev.stopPropagation();
    });

    elements.imagegradient.on('contextmenu', function(ev) {
      ev.stopPropagation();
    });

    container.on('contextmenu', function(ev) {
      ev.preventDefault();
      return false;
    });

    $('.css-gradient-editor-controller', container).on('keydown mousedown touchstart', function(e) {
      e.preventDefault();
      e.stopPropagation();

      updateControllerStates($(this));
    });

    $('.css-gradient-editor-controller', container).on('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
    });

    elements.anglecontroller.on('touchstart mousedown', function(ev) {
      angleInMove = true;

      changeAngle(ev);
      renderAngle();
      renderGradient();

      ev.stopPropagation();
      ev.preventDefault();
    });

    $(document).on('touchmove mousemove', function(ev) {
      if (!angleInMove) {
        return;
      }

      changeAngle(ev);
      renderAngle();
      renderGradient();
    });

    elements.angleinput.on('keyup', function() {
      var intRegex = /^\d+$/,
          val = $(this).val();

      if (val === '') {
        val = 0;
      }

      if (!intRegex.test(val)) {
        $(this).val(getPreference('linear_gradient_angle'));

        return false;
      }
      else {
        setPreference('linear_gradient_angle', val % 360);
        renderAngle(false);
        renderGradient();
        undoSaveState();
      }

    });

    elements.angleinput.on('blur', function() {
      var $this = $(this);

      if ($this.val() === '') {
        $this.val('0');
      }
      else {
        $this.val(getPreference('linear_gradient_angle'));
      }
    });

    $('.css-gradient-editor-controller[data-name=gradient_type], .css-gradient-editor-controller[data-name=gradient_shape]', container).on('touchstart mousedown click', function() {
      updatePreferencesVisibility();
      undoSaveState();
    });

    container.on('click', '.input-group-addon.bootstrap-touchspin-postfix', function() {
      changeUnit($(this));
      renderGradient();
      undoSaveState();
    });

    $('.css-gradient-editor-radial-preferences input').on('change keyup', function() {
      renderGradient();
    });

    elements.addstoppointbutton.on('click', function() {
      addColorStop({
        position: 0,
        unit: lastunit,
        color: lastSelectedColor
      });

      renderAll();
      undoSaveState();
    });

    elements.reorderstoppointsbutton.on('click', function() {
      renderColorStopsList();
    });

    $('.css-gradient-editor-stoppointlist', container).on('click', '.bootstrap-touchspin-postfix', function() {
      var $this = $(this),
          $row = $this.closest('.css-gradient-editor-stoppointdata'),
          newunit;

      if ($this.html() === '%') {
        newunit = 'px';
      }
      else {
        newunit = '%';
      }

      lastunit = newunit;

      if (getConfig('config_mixedstoppointunits') === 'enabled') {
        $this.html(newunit);
        $row.data('unit', newunit);
        setColorStopData($this.closest('.css-gradient-editor-stoppointdata').data('index'), 'unit', newunit);
      }
      else {
        $('.bootstrap-touchspin-postfix', elements.colorstopslist).each(function() {
          var $this = $(this);
          $this.html(newunit);
          $this.parents('.css-gradient-editor-stoppointdata').data('unit', newunit);
        });
        setColorStopData(false, 'unit', newunit);
      }

      renderColorStopMarkers();
      renderGradient();
      undoSaveState();
    });

    elements.swatches.on('click', 'li .css-gradient-editor-preset', function(ev) {
      loadGradient($(this).data('gradient'));
      ev.preventDefault();
    });

    elements.swatches_add.on('click', function(ev) {
      addCurrentGradientToSwatches();
      ev.preventDefault();
    });

    elements.swatches_remove.on('click', function(ev) {
      removeActualGradientFromSwatches();
      ev.preventDefault();
    });

    $(document).on('touchmove mousemove', function(ev) {
      if (!hueSliderInMove) {
        return;
      }

      var position = calculateEventPosition(ev, elements.coloroffsethue.parent());

      elements.coloroffsethue.css('left', position.horizontal.percent + '%');

      coloroffset.hue = Math.round(position.horizontal.percent * 3.6 - 180);
      elements.coloroffsethue.tooltip('hide');
      elements.coloroffsethue.data('bs.tooltip').options.title = 'hue: ' + (coloroffset.hue > 0 ? '+' : '') + coloroffset.hue;
      elements.coloroffsethue.tooltip('show');

      applyColorOffsets();
      updateColorStopsList(true);
      updateEasyColorstops();
      renderColorStopMarkers();
      renderGradient();

      ev.stopPropagation();
      ev.preventDefault();
    });

    $(document).on('touchmove mousemove', function(ev) {
      if (!chromaSliderInMove) {
        return;
      }

      var position = calculateEventPosition(ev, elements.coloroffsetchroma.parent());

      elements.coloroffsetchroma.css('left', position.horizontal.percent + '%');

      coloroffset.saturation = Math.round(position.horizontal.percent * 2 - 100);
      elements.coloroffsetchroma.tooltip('hide');
      elements.coloroffsetchroma.data('bs.tooltip').options.title = 'chroma: ' + (coloroffset.saturation > 0 ? '+' : '') + coloroffset.saturation;
      elements.coloroffsetchroma.tooltip('show');

      applyColorOffsets();
      updateColorStopsList(true);
      updateEasyColorstops();
      renderColorStopMarkers();
      renderGradient();

      ev.stopPropagation();
      ev.preventDefault();
    });

    $(document).on('touchmove mousemove', function(ev) {
      if (!lightnessSliderInMove) {
        return;
      }

      var position = calculateEventPosition(ev, elements.coloroffsetlightness.parent());

      elements.coloroffsetlightness.css('left', position.horizontal.percent + '%');

      coloroffset.lightness = Math.round(position.horizontal.percent * 2 - 100);
      elements.coloroffsetlightness.tooltip('hide');
      elements.coloroffsetlightness.data('bs.tooltip').options.title = 'lightness: ' + (coloroffset.lightness > 0 ? '+' : '') + coloroffset.lightness;
      elements.coloroffsetlightness.tooltip('show');

      applyColorOffsets();
      updateColorStopsList(true);
      updateEasyColorstops();
      renderColorStopMarkers();
      renderGradient();

      ev.stopPropagation();
      ev.preventDefault();
    });

    $(document).on('touchend mouseup', function() {
      if (hueSliderInMove || chromaSliderInMove || lightnessSliderInMove) {
        hueSliderInMove = false;
        chromaSliderInMove = false;
        lightnessSliderInMove = false;

        try {
          elements.coloroffsethue.tooltip('hide');
          elements.coloroffsetchroma.tooltip('hide');
          elements.coloroffsetlightness.tooltip('hide');
        }
        catch (e) {
        }
      }

      undoSaveState();
    });

    $(window).resize(function() {
      updateStickyPreviewHeight();
    });

    elements.cssoutput.on('click', function(e) {
      selectAllText($(this));

      e.preventDefault();
      e.stopPropagation();
    });

    elements.exportallmodal.on('show.bs.modal', function() {
      elements.exportalltextarea.val(JSON.stringify(swatches).split('",').join('",' + '\n'));
    });

    elements.importmodal.on('shown.bs.modal', function() {
      elements.importtextarea.focus();
    });

    elements.importmodal.on('hide.bs.modal', function() {
      importGradients(elements.importtextarea.val());
    });

    elements.configmodal.on('hide.bs.modal', function() {
      renderAll();
    });

    elements.exportalltextarea.on('focus', function() {
      var $this = $(this);

      $this.select();

      window.setTimeout(function() {
        $this.select();
      }, 1);

      // webkit workaround
      function mouseUpHandler() {
        $this.off('mouseup', mouseUpHandler);
        return false;
      }

      $this.mouseup(mouseUpHandler);
    });

    $(document).on('change', '.bootstrap-touchspin input', function() {
      $(this).closest('.css-gradient-editor-controller').trigger('mousedown');
    });
  }

  function initConfigValues() {
    $('[data-name^=config_]', container).each(function() {
      var $this = $(this),
          name = $this.data('name'),
          value = $this.data('value'),
          configvalue = getConfig(name);

      if (typeof $this.data('value') === 'undefined') {
        $this.data('config-toggle', true);
      }

      if ($this.data('controlGroup')) {
        if (configvalue === value) {
          if ($this.is('input[type=text]')) {
            $this.val(configvalue);
          }
          else {
            $this.addClass('active');
            if (typeof $this.data('value') === 'undefined') {
              $this.data('value', true);
            }
          }
        }
        else {
          if (typeof $this.data('value') === 'undefined') {
            $this.data('value', false);
          }
        }
      }
      else {
        if (getConfig(name)) {
          if ($this.is('input[type=text]')) {
            $this.val(configvalue);
          }
          else {
            $this.addClass('active');
            if (typeof $this.data('value') === 'undefined') {
              $this.data('value', true);
            }
          }
        }
        else {
          if (typeof $this.data('value') === 'undefined') {
            $this.data('value', false);
          }
        }
      }
    });
  }

  function bindConfigEvents() {
    $('input[name=config-fallbackwidth]').on('change', function() {
      var $this = $(this);

      setConfig($this.data('name'), $this.val());
    });
    $('input[name=config-fallbackheight]').on('change', function() {
      var $this = $(this);

      setConfig($this.data('name'), $this.val());
    });
    $('input[name=config-cssselector]').on('change', function() {
      var $this = $(this);

      setConfig($this.data('name'), $this.val());
    });
  }

  function updateControllerStates($this) {
    var name = $this.data('name'),
        value = $this.data('value');

    if (name.indexOf('config_') !== 0) {
      if (getPreference(name) === value) {
        return;
      }
      $this.addClass('active');
      setPreference(name, value);
    }
    else {
      if (!!$this.data('control-group')) {
        if (getConfig(name) === value) {
          return;
        }
        $this.addClass('active');
        setConfig(name, value);
      }
      else {
        if ($this.hasClass('active')) {
          setConfig(name, false);
          $this.removeClass('active');
        }
        else {
          setConfig(name, true);
          $this.addClass('active');
        }
      }
    }

    $('.css-gradient-editor-controller.active[data-control-group="' + $this.data('control-group') + '"]', container).removeClass('active').blur();

    $('.css-gradient-editor-controller[data-control-group="' + $this.data('control-group') + '"][data-name="' + name + '"][data-value="' + value + '"]', container).addClass('active');

    renderGradient();
  }

  function selectAllText(el) {
    el = el.get(0);
    if (typeof window.getSelection !== 'undefined' && typeof document.createRange !== 'undefined') {
      var range = document.createRange();
      range.selectNodeContents(el);
      var sel = window.getSelection();
      sel.removeAllRanges();
      sel.addRange(range);
    } else if (typeof document.selection !== 'undefined' && typeof document.body.createTextRange !== 'undefined') {
      var textRange = document.body.createTextRange();
      textRange.moveToElementText(el);
      textRange.select();
    }
  }

  function loadGradient(gradient, saveundostate) {
    if (typeof saveundostate === 'undefined') {
      saveundostate = true;
    }
    elements.preview.addClass('ajax-loader');

    setTimeout(function() {
      gradientready = false;
      nullColorOffsets();
      removeAllColorStops();
      initData(gradient);
      updateInputValues();
      initControllers();
      setTimeout(function() {
        renderAll(saveundostate);
        elements.preview.removeClass('ajax-loader');
      }, 100);
      findActualGradientsSwatch();
      updateToolbar();
      updateCssOutput();
      setupLayout();
    }, 100);
  }

  function setColorStopData(index, name, value) {
    var i;

    if (index === false) {
      for (i = 0; i < colorStops.length; i++) {
        colorStops[i][name] = value;
      }
    }
    else {
      for (i = 0; i < colorStops.length; i++) {
        if (colorStops[i].index === index) {
          colorStops[i][name] = value;
          break;
        }
      }
    }
  }

  function changeUnit(element, newunit) {
    var currentunit = element.html(),
        previnput = element.prev('input'),
        availableunits = previnput.data('units');

    if (typeof (newunit) === 'undefined') {
      newunit = '';

      if (typeof (availableunits) === 'undefined') {
        return;
      }

      var currentindex = availableunits.indexOf(currentunit);

      if (availableunits.length > currentindex + 1) {
        newunit = availableunits[currentindex + 1];
      }
      else {
        newunit = availableunits[0];
      }

    }

    element.html(newunit);
    saveInputPreference(previnput);
  }

  function updatePreferencesVisibility(update_gradient_type) {
    if (typeof (update_gradient_type) === 'undefined') {
      update_gradient_type = false;
    }

    var gradient_type = getPreference('gradient_type');

    if (gradient_type === 'linear') {
      $('.css-gradient-editor-linear-preferences', container).show();
      $('.css-gradient-editor-radial-preferences', container).hide();

      if (update_gradient_type) {
        $('[data-name=gradient_type][data-value=linear]').trigger('mousedown');
      }
    }
    else if (gradient_type === 'radial') {
      $('.css-gradient-editor-linear-preferences', container).hide();
      $('.css-gradient-editor-radial-preferences', container).show();

      if (update_gradient_type) {
        $('[data-name=gradient_type][data-value=radial]').trigger('mousedown');
      }

      var gradient_shape = getPreference('gradient_shape');

      if (gradient_shape === 'circle') {
        $('input[name=gradient_size_major]').parent().hide();
      }
      else {
        $('input[name=gradient_size_major]').parent().show();
      }
    }

    renderAngle();
  }

  function changeAngle(ev) {
    var c = getEventCoordinates(ev),
        offset = elements.anglecontroller.offset(),
        width = elements.anglecontroller.width(),
        height = elements.anglecontroller.height();

    if (c === false) {
      angleInMove = false;
      return false;
    }

    var xd = Math.round(c.pageX - offset.left - width / 2),
        yd = Math.round(c.pageY - offset.top - height / 2);

    var rotation_angle = Math.round(getDegreeFromDistance(xd, yd) + 90) % 360;

    setPreference('linear_gradient_angle', rotation_angle);
  }

  function renderAngle(updateinput) {
    var linear_gradient_angle = getPreference('linear_gradient_angle');
    if (typeof updateinput === 'undefined') {
      updateinput = true;
    }

    elements.angleline.css('-webkit-transform', 'rotate(' + linear_gradient_angle + 'deg)');
    elements.angleline.css('-ms-transform', 'rotate(' + linear_gradient_angle + 'deg)');
    elements.angleline.css('transform', 'rotate(' + linear_gradient_angle + 'deg)');

    if (updateinput) {
      elements.angleinput.val(linear_gradient_angle);
    }
  }

  function bindColorstopMarkerEvents(colorstopmarker) {
    colorstopmarker.on('touchstart mousedown', function(ev) {
      // enable for left click only
      if (ev.which > 1) {
        return;
      }

      stopPointDragTarget = $(this);

      setSelectedIndex(stopPointDragTarget.data('index'));
      renderStopPointSelections();

      ev.stopPropagation();
      ev.preventDefault();
    });

    colorstopmarker.on('click', function(ev) {
      ev.stopPropagation();
      ev.preventDefault();
    });
  }

  function renderStopPointSelections(enablecolorpopupmove) {
    if (typeof (enablecolorpopupmove) === 'undefined') {
      enablecolorpopupmove = true;
    }

    $('.color-stop, .css-gradient-editor-stoppointdata').each(function() {
      var $this = $(this);
      if (isSelected($this.data('index'))) {
        $this.addClass('selected');
        lastSelectedColor = $this.data('color');
      }
      else {
        $this.removeClass('selected');
      }
    });

    if (enablecolorpopupmove) {
      hideColorPopups();
    }
  }

  function setSelectedIndex(index) {
    _selectedStopIndex = index;
  }

  function isSelected(index) {
    return index === _selectedStopIndex;
  }

  function detectDeleteState(ev) {
    var originalOffset = elements.markersarea.offset(),
        eventCoordinates = getEventCoordinates(ev),
        markForDeath = false;

    var deltaY;

    if (eventCoordinates.pageY > (originalOffset.top)) {
      deltaY = Math.abs(eventCoordinates.pageY - 18 - originalOffset.top);
    }
    else {
      deltaY = Math.abs(eventCoordinates.pageY + 7 - originalOffset.top);
    }

    if (deltaY > settings.remove_distance) {
      if (stopPointDragTarget.data('mark-for-death')) {
        return;
      }

      stopPointDragTarget.data('mark-for-death', 1);

      stopPointDragTarget.hide();

      markForDeath = true;
    }
    else {
      if (!stopPointDragTarget.data('mark-for-death')) {
        return;
      }

      stopPointDragTarget.data('mark-for-death', 0);

      stopPointDragTarget.show();

      markForDeath = false;
    }

    setColorStopData(stopPointDragTarget.data('index'), 'markForDeath', markForDeath);
  }

  function getEventCoordinates(ev) {
    if (typeof ev.pageX !== 'undefined') {
      return {
        pageX: ev.pageX,
        pageY: ev.pageY
      };
    }
    else if (typeof ev.originalEvent !== 'undefined' && typeof ev.originalEvent.touches !== 'undefined') {
      return {
        pageX: ev.originalEvent.touches[0].pageX,
        pageY: ev.originalEvent.touches[0].pageY
      };
    }
    else {
      return false;
    }
  }

  function calculateEventPosition(ev, containerElement) {
    var c = getEventCoordinates(ev);

    var sizeX = containerElement.width(),
        offsetX = c.pageX - containerElement.offset().left,
        sizeY = containerElement.height(),
        offsetY = c.pageY - containerElement.offset().top;

    var percentX = offsetX / sizeX * 100,
        percentY = offsetY / sizeY * 100;

    if (percentX < 0) {
      percentX = 0;
    }

    if (percentX > 100) {
      percentX = 100;
    }

    if (percentY < 0) {
      percentY = 0;
    }

    if (percentY > 100) {
      percentY = 100;
    }

    return {
      horizontal: {
        percent: percentX,
        pixel: offsetX
      },
      vertical: {
        percent: percentY,
        pixel: offsetY
      }
    };
  }

  function addColorStop(data) {
    var element = {
      index: colorStopIndex++,
      position: data.position,
      unit: data.unit || lastunit,
      color: data.color,
      markForDeath: false
    };

    lastunit = element.unit;

    colorStops.push(element);

    setSelectedIndex(element.index);
  }

  function renderAll(saveundo) {
    if (typeof saveundo === 'undefined') {
      saveundo = false;
    }

    renderGradient();
    renderColorStopMarkers();
    clearColorStopsList();
    renderEasyColorstops();
    setTimeout(function() {
      renderColorStopsList();
      elements.colorstopslist.removeClass('ajax-loader');
      if (saveundo) {
        undoSaveState();
      }
      gradientready = true;
    }, 20);
  }

  function removeAllColorStops() {
    colorStops = [];
    colorStopIndex = 0;
    setSelectedIndex(-1);
  }

  function removeColorStop(index) {
    for (var i = 0; i < colorStops.length; i++) {
      if (colorStops[i].index === index) {
        colorStops.splice(i, 1);
        $('input.css-gradient-editor-stop-point-color', elements.colorstopslist).trigger('colorpickersliders.hide');
        break;
      }
    }

    renderGradient();
    renderColorStopMarkers();
    renderColorStopsList();
  }

  function moveDragTarget(position) {
    var currentunit = stopPointDragTarget.data('unit'),
        positioninunit;

    if (currentunit === '%') {
      positioninunit = position.horizontal.percent;
    }
    else {
      positioninunit = position.horizontal.pixel;
    }

    if (positioninunit < MIN) {
      positioninunit = MIN;
    }
    else if (positioninunit > MAX) {
      positioninunit = MAX;
    }

    stopPointDragTarget.css('left', positioninunit + currentunit).data({
      position: positioninunit,
      unit: currentunit
    });

    setColorStopData(stopPointDragTarget.data('index'), 'position', positioninunit);

    renderGradient();
    updateColorStopsList();
    setStopPointHandlerVisibility();
  }

  function clearColorStopsList() {
    $('input.css-gradient-editor-stop-point-color', elements.colorstopslist).each(function() {
      $(this).trigger('colorpickersliders.hide');
    });

    elements.addstoppointbutton.hide();
    elements.colorstopslist.addClass('ajax-loader');
  }

  function getColorPickerConfig() {
    var sliders = {},
        count = 0,
        swatches = getConfig('config_colorpicker_swatches'),
        previewformat = getConfig('config_colorformat') || 'rgb';

    if (getConfig('config_colorpicker_hsl')) {
      sliders.hsl = count++;
    }

    if (getConfig('config_colorpicker_rgb')) {
      sliders.rgb = count++;
    }

    if (getConfig('config_colorpicker_cie')) {
      sliders.cie = count++;
    }

    if (getConfig('config_colorpicker_opacity')) {
      sliders.opacity = count + 1;
    }

    if (count === 0 && !swatches) {
      sliders.hsl = 0;
    }

    return {
      swatches: swatches,
      sliders: sliders,
      previewformat: previewformat
    };
  }

  function updateEasyColorstops() {
    var cs = getVisibleColorStops();

    elements.inputfrom.trigger('colorpickersliders.updateColor', cs[0].color);
    elements.inputto.trigger('colorpickersliders.updateColor', cs[1].color);
  }

  function renderEasyColorstops() {
    if (layout > LAYOUT_SIMPLE) {
      return;
    }

    var colorpickerconfig = getColorPickerConfig();

    $('.cp-container', elements.gradientpreferenceseasy).remove();

    var cs = getVisibleColorStops();

    if (cs.length > 0) {
      elements.inputfrom.val(cs[0].color);
    }

    if (cs.length > 1) {
      elements.inputto.val(cs[1].color);
    }

    elements.inputfrom.ColorPickerSliders({
      flat: true,
      order: colorpickerconfig.sliders,
      swatches: colorpickerconfig.swatches,
      previewformat: colorpickerconfig.previewformat,
      onchange: function(container, color) {
        if (!hueSliderInMove && !chromaSliderInMove && !lightnessSliderInMove) {
          nullColorOffsets();
          //_hideColorAdjust();
        }

        setColorStopData(0, 'color', color.tiny.toRgbString());
        lastSelectedColor = color.tiny.toRgbString();

        renderGradient();
      }
    });

    elements.inputto.ColorPickerSliders({
      flat: true,
      order: colorpickerconfig.sliders,
      swatches: colorpickerconfig.swatches,
      previewformat: colorpickerconfig.previewformat,
      onchange: function(container, color) {
        if (!hueSliderInMove && !chromaSliderInMove && !lightnessSliderInMove) {
          nullColorOffsets();
          //_hideColorAdjust();
        }

        setColorStopData(1, 'color', color.tiny.toRgbString());
        lastSelectedColor = color.tiny.toRgbString();

        renderGradient();
      }
    });
  }

  function renderColorStopsList() {
    if (layout === LAYOUT_SIMPLE) {
      return;
    }

    orderColorStops();

    elements.colorstopslist.empty();
    elements.addstoppointbutton.show();
    elements.reorderstoppointsbutton.prop('disabled', true);

    for (var i = 0; i < colorStops.length; i++) {
      var el = colorStops[i];
      var row = $('<div class="css-gradient-editor-stoppointdata clearfix"></div>');

      row.appendTo(elements.colorstopslist);
      $('<button type="button" class="btn btn-sm pull-right css-gradient-editor-stop-point-delete"><span class="pngicon-remove2"></span></button><input class="css-gradient-editor-stop-point-color input-sm" type="text" value="' + getRenderColor(el) + '"> <input class="css-gradient-editor-stop-point-position input-sm" type="text" value="' + el.position + '">').appendTo(row);

      row.data(el);

      $('input.css-gradient-editor-stop-point-position', row).TouchSpin({
        min: MIN,
        max: MAX,
        postfix: el.unit,
        decimals: settings.positiondecimals,
        step: Math.pow(0.1, settings.positiondecimals)
      });
    }

    $('.css-gradient-editor-stop-point-delete', elements.colorstopslist).on('click', function() {
      removeColorStop($(this).closest('.css-gradient-editor-stoppointdata').data('index'));
    });

    $('input.css-gradient-editor-stop-point-position', elements.colorstopslist).on('change', function() {
      var $this = $(this);

      var index = $this.closest('.css-gradient-editor-stoppointdata').data('index');

      setColorStopData(index, 'position', $this.val());

      setSelectedIndex(index);

      renderColorStopMarkers();
      renderStopPointSelections();
      renderGradient();
    }).on('touchspin.on.stopspin', function() {
      undoSaveState();
      updateReorderButtonState(false);
    });

    var colorpickerconfig = getColorPickerConfig();

    $('input.css-gradient-editor-stop-point-color', elements.colorstopslist).ColorPickerSliders({
      flat: false,
      placement: 'bottom',
      order: colorpickerconfig.sliders,
      swatches: colorpickerconfig.swatches,
      previewformat: colorpickerconfig.previewformat,
      onchange: function(container, color) {
        nullColorOffsets();

        _hideColorAdjust();

        var index = $(this)[0].connectedinput.closest('.css-gradient-editor-stoppointdata').data('index');

        setColorStopData(index, 'color', color.tiny.toRgbString());
        lastSelectedColor = color.tiny.toRgbString();

        renderColorStopMarkers();
        renderGradient();
      }
    });

    $('input', elements.colorstopslist).focus(function() {
      var index = $(this).closest('.css-gradient-editor-stoppointdata').data('index');
      setSelectedIndex(index);
      renderStopPointSelections(false);
    });
  }

  function renderColorStopMarkers() {
    if (layout === LAYOUT_SIMPLE) {
      return;
    }

    orderColorStops();

    elements.markersarea.empty();

    for (var i = 0; i < colorStops.length; i++) {
      var el = colorStops[i];
      var added = $('<div></div>').appendTo(elements.markersarea);

      added.addClass('color-stop').css('left', el.position + el.unit).data(el);

      bindColorstopMarkerEvents(added);

      var tp = $('<div></div>');
      var bg = $('<span></span>');

      tp.html(bg);
      added.html(tp);

      bg.css('background-color', getRenderColor(el));
    }

    setStopPointHandlerVisibility();
  }

  function setStopPointHandlerVisibility() {
    $('.color-stop', elements.markersarea).each(function() {
      var $this = $(this),
          overvalue;

      if ($this.data('unit') === '%') {
        overvalue = 100;
      }
      else {
        overvalue = $this.parents('.css-gradient-editor-stoppointmarkers').width();
      }

      if ($this.data('position') > overvalue) {
        $this.addClass('overflow');
        $this.removeClass('underflow');
      }
      else if ($this.data('position') < 0) {
        $this.addClass('underflow');
        $this.removeClass('overflow');
      }
      else {
        $this.removeClass('underflow');
        $this.removeClass('overflow');
      }
    });
  }

  function updateColorStopsList(updateColor) {
    if (layout === LAYOUT_SIMPLE) {
      return;
    }

    if (typeof updateColor === 'undefined') {
      updateColor = false;
    }

    $('.css-gradient-editor-stoppointdata', elements.colorstopslist).each(function() {
      var $this = $(this);

      for (var i = 0; i < colorStops.length; i++) {
        var el = colorStops[i];

        if (el.index === $this.data('index')) {
          $('input.css-gradient-editor-stop-point-position', $this).val(Number(el.position).toFixed(settings.positiondecimals));
          if (updateColor) {
            $('input.css-gradient-editor-stop-point-color', $this).trigger('colorpickersliders.updateColor', el.color);
          }
        }

      }
    });
  }

  function getPreference(name, dataset) {
    var data;

    if (typeof dataset === 'undefined') {
      data = container.data(name);
    }
    else {
      data = dataset.data[name];
    }

    if (typeof data === 'undefined') {
      console.log('missing preference: ' + name);
    }

    return data;
  }

  function setPreference(name, value) {
    if (typeof (container.data(name)) === 'undefined') {
      console.log('Uninitialized preference: ' + name);
    }
    container.data(name, value);
  }

  function getShortenedPreferenceName(s) {
    return shorteningdata[s];
  }

  function getOriginalPreferenceName(s) {
    for (var key in shorteningdata) {
      if (shorteningdata[key] === s) {
        return key;
      }
    }
  }

  function getGradientQueryString() {
    var pd = $.extend({}, container.data()),
        queryarray = [],
        stoppointarray = [],
        querydata = '',
        stoppointdata = '';

    if (pd.gradient_type === 'linear') {
      delete pd.gradient_size;
      delete pd.gradient_size_unit;
      delete pd.gradient_size_value;
      delete pd.gradient_size_major_unit;
      delete pd.gradient_size_major_value;
      delete pd.gradient_shape;
      delete pd.gradient_position_vertical;
      delete pd.gradient_position_vertical_unit;
      delete pd.gradient_position_vertical_value;
      delete pd.gradient_position_horizontal;
      delete pd.gradient_position_horizontal_unit;
      delete pd.gradient_position_horizontal_value;
      if (pd.gradient_direction !== 'angle') {
        delete pd.linear_gradient_angle;
      }
    }
    else if (pd.gradient_type === 'radial') {
      delete pd.gradient_direction;
      delete pd.linear_gradient_angle;

      if (pd.gradient_shape !== 'ellipse' || pd.gradient_size !== 'explicit') {
        delete pd.gradient_size_major_unit;
        delete pd.gradient_size_major_value;
      }
      if (pd.gradient_size !== 'explicit') {
        delete pd.gradient_size_unit;
        delete pd.gradient_size_value;
      }
      if (pd.gradient_position_horizontal !== 'explicit') {
        delete pd.gradient_position_horizontal_unit;
        delete pd.gradient_position_horizontal_value;
      }
      if (pd.gradient_position_vertical !== 'explicit') {
        delete pd.gradient_position_vertical_unit;
        delete pd.gradient_position_vertical_value;
      }
    }

    for (var key in pd) {
      if (pd.hasOwnProperty(key)) {
        queryarray.push(getShortenedPreferenceName(key) + '=' + encodeURIComponent(pd[key]));
      }
    }

    var colorStops = getVisibleColorStops();

    for (var i = 0; i < colorStops.length; i++) {
      var t = tinycolor(getRenderColor(colorStops[i]));
      var colorstring = t.getAlpha() < 1 ? t.toHex8() : t.toHex();
      stoppointarray.push(encodeURIComponent(colorstring) + '_' + encodeURIComponent(Math.round(colorStops[i].position * 10) / 10) + '_' + encodeURIComponent(colorStops[i].unit));
    }

    querydata = queryarray.join('&');
    stoppointdata = stoppointarray.join('__');

    return querydata + '&sp=' + stoppointdata;
  }

  function updateToolbar() {
    currentgradient = getGradientQueryString();

    elements.permalink.attr('href', window.location.pathname + '?' + currentgradient).data('querystring', currentgradient);
    elements.imagegradient.attr('href', '/assets/css-gradient-generator/gradient.php?' + currentgradient);

    if (typeof window.history.pushState === 'function') {
      window.history.replaceState({}, '', window.location.pathname + '?' + currentgradient);
    }

    findActualGradientsSwatch();

    updateQR();
  }

  function orderColorStops(stops) {
    if (typeof stops === 'undefined') {
      stops = colorStops;
    }

    colorStops.sort(function(a, b) {
      return a.position - b.position;
    });
  }

  function updateReorderButtonState(livereorder) {
    if (typeof livereorder === 'undefined') {
      livereorder = true;
    }

    var prevpos = 0,
        dirty = false;

    $('.css-gradient-editor-stoppointdata input.css-gradient-editor-stop-point-position', elements.colorstopslist).each(function() {
      var currentpos = parseFloat($(this).val());

      if (currentpos < prevpos) {
        dirty = true;
      }

      prevpos = currentpos;
    });

    if (dirty) {
      elements.reorderstoppointsbutton.prop('disabled', false);
      if (livereorder) {
        renderColorStopsList();
        renderStopPointSelections();
      }
    }
    else {
      elements.reorderstoppointsbutton.prop('disabled', true);
    }
  }

  function getStopPointsString(dataset) {
    var colorStops = getVisibleColorStops(dataset);

    if (colorStops.length < 2) {
      return false;
    }

    orderColorStops(colorStops);

    var stoppoints = '';

    for (var i = 0; i < colorStops.length; i++) {
      var el = colorStops[i];

      stoppoints += ',' + getRenderColor(el) + ' ' + Math.round(el.position * 10) / 10 + el.unit;
    }

    stoppoints += ')';

    return stoppoints;
  }

  function recalculatePosition(position, min, max) {
    var length = max - min,
        percent = (position - min) / length;

    return Math.round(percent * 1000) / 1000;
  }

  function getOldWebkitStopPointsData(dataset) {
    var points = getRepeatingStopPoints(dataset),
        stoppoints = '';

    for (var i = 0; i < points.length; i++) {
      stoppoints += ',color-stop(' + Math.round(points[i].position * 10) / 1000 + ', ' + getRenderColor(points[i]) + ')';
    }

    return stoppoints;
  }

  function fixEndpoints(points) {
    if (points.length < 2) {
      return points;
    }

    var p_modify,
        p_other,
        length,
        weight_modify,
        p_modify_rgb,
        p_other_rgb,
        reddiff,
        greendiff,
        bluediff,
        newrgb;

    if (points[0].position < 0) {
      p_modify = points[0];
      p_other = points[1];

      length = p_other.position - p_modify.position;

      weight_modify = 1 - p_other.position / length;

      p_modify_rgb = tinycolor(p_modify.color).toRgb();
      p_other_rgb = tinycolor(p_other.color).toRgb();

      reddiff = p_other_rgb.r - p_modify_rgb.r;
      greendiff = p_other_rgb.g - p_modify_rgb.g;
      bluediff = p_other_rgb.b - p_modify_rgb.b;

      newrgb = {
        r: Math.round(p_modify_rgb.r + weight_modify * reddiff),
        g: Math.round(p_modify_rgb.g + weight_modify * greendiff),
        b: Math.round(p_modify_rgb.b + weight_modify * bluediff)
      };

      points[0].color = tinycolor(newrgb).toRgbString();
      points[0].position = 0;

    }


    if (points[points.length - 1].position > 100) {
      p_modify = points[points.length - 1];
      p_other = points[points.length - 2];

      length = Math.abs(p_other.position - p_modify.position);

      weight_modify = 1 - (p_modify.position - 100) / length;

      p_modify_rgb = tinycolor(p_modify.color).toRgb();
      p_other_rgb = tinycolor(p_other.color).toRgb();

      reddiff = p_other_rgb.r - p_modify_rgb.r;
      greendiff = p_other_rgb.g - p_modify_rgb.g;
      bluediff = p_other_rgb.b - p_modify_rgb.b;

      newrgb = {
        r: Math.round(p_modify_rgb.r + weight_modify * reddiff),
        g: Math.round(p_modify_rgb.g + weight_modify * greendiff),
        b: Math.round(p_modify_rgb.b + weight_modify * bluediff)
      };

      points[points.length - 1].color = tinycolor(newrgb).toRgbString();
      points[points.length - 1].position = 100;
    }

  }

  function getRepeatingStopPoints(dataset) {
    var colorStops = getVisibleColorStops(dataset),
        min = false,
        max = false,
        i;

    orderColorStops(colorStops);

    if (colorStops.length < 2) {
      return;
    }

    min = colorStops[0].position;
    max = colorStops[colorStops.length - 1].position;
    var length = Math.max(max - min, 1);

    var offsetmultiplier = 0,
        lastposition = 0,
        repeat = getPreference('gradient_repeat', dataset);

    if (repeat === 'on') {
      offsetmultiplier = -Math.ceil(min / length);
    }

    var points = [];

    var step = 0;

    do {
      for (i = 0; i < colorStops.length; i++) {
        var position,
            unit;

        position = colorStops[i].position;
        unit = colorStops[i].unit;

        if (colorStops[i].unit !== '%') {
          unit = '%';
          position = recalculatePosition(position, min, max);
        }
        else {
          position = Math.round(position * 10) / 10;
        }

        position += offsetmultiplier * length;
        lastposition = position;

        points[step++] = {
          color: colorStops[i].color,
          position: position
        };
      }
      ++offsetmultiplier;
    } while (repeat === 'on' && lastposition < 100);

    var splice_start = 0,
        splice_end = points.length;

    for (i = 0; i < points.length; i++) {
      if (points[i].position < 0) {
        splice_start = i;
      }
      else if (points[i].position > 100) {
        splice_end = i;
        break;
      }
    }

    points = points.splice(splice_start, splice_end - splice_start + 1);

    fixEndpoints(points);

    return points;
  }

  function getSvgStopPointsData(dataset) {
    var points = getRepeatingStopPoints(dataset),
        stoppoints = '';

    for (var i = 0; i < points.length; i++) {
      stoppoints += '<stop ' + getSvgStyle(points[i]) + ' offset="' + points[i].position / 100 + '"/>';
    }

    return stoppoints;
  }

  function getVisibleColorStops(dataset) {
    var colorStops = getColorStops(dataset),
        index = 0,
        stoppoints = [];

    orderColorStops(colorStops);

    for (var i = 0; i < colorStops.length; i++) {

      if (colorStops[i].markForDeath) {
        continue;
      }

      stoppoints[index++] = $.extend({}, colorStops[i]);
    }

    return stoppoints;
  }

  function simplifyDirection(dataset) {
    var gradient_direction = getPreference('gradient_direction', dataset),
        direction = 'right';

    switch (getPreference('gradient_type', dataset)) {
      case 'linear':
        if (gradient_direction === 'angle') {
          var angle = getPreference('linear_gradient_angle', dataset);

          if (angle > 325 || angle < 45) {
            direction = 'top';
          }
          else if (angle < 135) {
            direction = 'right';
          }
          else if (angle < 160) {
            direction = 'bottom';
          }
          else {
            direction = 'left';
          }
        }
        else {
          switch (gradient_direction) {
            case 'top':
              direction = 'top';
              break;
            case 'top left':
              direction = 'top';
              break;
            case 'top right':
              direction = 'top';
              break;
            case 'left':
              direction = 'left';
              break;
            case 'bottom':
              direction = 'bottom';
              break;
            case 'bottom left':
              direction = 'bottom';
              break;
            case 'bottom right':
              direction = 'bottom';
              break;
            case 'right':
              direction = 'right';
              break;
          }
        }
        break;
      case 'radial':
        direction = 'bottom';
        break;
    }

    return direction;
  }

  function getIEFilter(dataset) {
    var colorStops = getVisibleColorStops(dataset);

    if (colorStops.length < 2) {
      return false;
    }

    var color0 = tinycolor(colorStops[0].color).toHex8String(),
        color1 = tinycolor(colorStops[colorStops.length - 1].color).toHex8String(),
        start,
        end,
        direction = simplifyDirection();

    switch (direction) {
      case 'top':
        start = color1;
        end = color0;
        direction = '0';
        break;
      case 'right':
        start = color0;
        end = color1;
        direction = '1';
        break;
      case 'bottom':
        start = color0;
        end = color1;
        direction = '0';
        break;
      case 'left':
        start = color1;
        end = color0;
        direction = '1';
        break;
    }

    return 'progid:DXImageTransform.Microsoft.gradient(startColorstr="' + start + '",endColorstr="' + end + '",GradientType=' + direction + ')';
  }

  function getValueWithUnit(name, dataset) {
    var value, unit;

    if (typeof dataset === 'undefined') {
      value = $('input[name="' + name + '"]').val();
      unit = $('input[name="' + name + '"]').next('span.input-group-addon.bootstrap-touchspin-postfix').html();
    }
    else {
      value = dataset.data[name + '_value'];
      unit = dataset.data[name + '_unit'];
    }

    return value + unit;
  }

  function webkitGradientDirectionKeyword(direction_keyword) {
    switch (direction_keyword) {
      case 'top':
        return 'bottom';
      case 'left':
        return 'right';
      case 'bottom':
        return 'top';
      case 'right':
        return 'left';
      case 'top left':
        return 'bottom right';
      case 'top right':
        return 'bottom left';
      case 'bottom left':
        return 'top right';
      case 'bottom right':
        return 'top left';
    }
  }

  function getOldWebkitLinear(dataset, gradient_direction) {
    var oldwebkit = '-webkit-gradient(linear, ',
        stoppoints = getOldWebkitStopPointsData(dataset);

    if (gradient_direction === 'angle') {
      var angle = getPreference('linear_gradient_angle', dataset);

      var coords = getCoordsForAngle(angle);

      oldwebkit += coords.x1 + ' ' + coords.y1 + ', ' + coords.x2 + ' ' + coords.y2;
    }
    else {
      switch (gradient_direction) {
        case 'top':
          oldwebkit += '0% 100%, 0% 0%';
          break;
        case 'top left':
          oldwebkit += '100% 100%, 0% 0%';
          break;
        case 'top right':
          oldwebkit += '0% 100%, 100% 0%';
          break;
        case 'left':
          oldwebkit += '100% 0%, 0% 0%';
          break;
        case 'bottom':
          oldwebkit += '0% 0%, 0% 100%';
          break;
        case 'bottom left':
          oldwebkit += '100% 0%, 0% 100%';
          break;
        case 'bottom right':
          oldwebkit += '0% 0%, 100% 100%';
          break;
        case 'right':
          oldwebkit += '0% 0%, 100% 0%';
          break;
      }
    }

    oldwebkit += stoppoints + ')';

    return oldwebkit;
  }

  function getCoordsForAngle(angle) {
    var xs, ys,
        tan = Math.round(Math.tan(angle % 45 * Math.PI / 180) * 50);

    var sin = Math.sin((angle - 45) * 4 * Math.PI / 180);
    var maxi = 6 * Math.sqrt(2);
    var modifier = Math.abs(sin * maxi);

    if (angle >= 0 && angle < 45) {
      xs = tan + modifier;
      ys = -50 - modifier;
    }
    if (angle >= 45 && angle < 90) {
      xs = 50 + modifier;
      ys = -50 + tan - modifier;
    }
    if (angle >= 90 && angle < 135) {
      xs = 50 + modifier;
      ys = tan + modifier;
    }
    if (angle >= 135 && angle < 180) {
      xs = 50 - tan + modifier;
      ys = 50 + modifier;
    }
    if (angle >= 180 && angle < 225) {
      xs = -tan - modifier;
      ys = 50 + modifier;
    }
    if (angle >= 225 && angle < 270) {
      xs = -50 - modifier;
      ys = 50 - tan + modifier;
    }
    if (angle >= 270 && angle < 315) {
      xs = -50 - modifier;
      ys = -tan - modifier;
    }
    if (angle >= 315 && angle < 360) {
      xs = -50 + tan - modifier;
      ys = -50 - modifier;
    }

    return {
      xs: xs,
      ys: ys,
      x1: Math.round((50 - xs) * 10) / 10 + '%',
      y1: Math.round((50 - ys) * 10) / 10 + '%',
      x2: Math.round((50 + xs) * 10) / 10 + '%',
      y2: Math.round((50 + ys) * 10) / 10 + '%'
    };
  }

  function getSvgLinear(dataset, gradient_direction) {
    var svg = '',
        svgstoppoints = getSvgStopPointsData(dataset),
        from = '0%',
        to = '100%',
        x1, y1, x2, y2;

    if (gradient_direction === 'angle') {
      var angle = getPreference('linear_gradient_angle', dataset);
      var coords = getCoordsForAngle(angle);

      x1 = coords.x1;
      y1 = coords.y1;
      x2 = coords.x2;
      y2 = coords.y2;
    }
    else {
      switch (gradient_direction) {
        case 'top':
          x1 = '0%';
          y1 = to;
          x2 = '0%';
          y2 = from;
          break;
        case 'top left':
          x1 = '100%';
          y1 = '100%';
          x2 = '0%';
          y2 = '0%';
          break;
        case 'top right':
          x1 = '0%';
          y1 = '100%';
          x2 = '100%';
          y2 = '0%';
          break;
        case 'left':
          x1 = to;
          y1 = '0%';
          x2 = from;
          y2 = '0%';
          break;
        case 'bottom':
          x1 = '0%';
          y1 = from;
          x2 = '0%';
          y2 = to;
          break;
        case 'bottom left':
          x1 = '100%';
          y1 = '0%';
          x2 = '0%';
          y2 = '100%';
          break;
        case 'bottom right':
          x1 = '0%';
          y1 = '0%';
          x2 = '100%';
          y2 = '100%';
          break;
        case 'right':
          x1 = from;
          y1 = '0%';
          x2 = to;
          y2 = '0%';
          break;
      }
    }

    svg = '<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 1 1" preserveAspectRatio="none"><linearGradient id="vsgg" gradientUnits="userSpaceOnUse" x1="' + x1 + '" y1="' + y1 + '" x2="' + x2 + '" y2="' + y2 + '">';

    svg += svgstoppoints;

    svg += '</linearGradient><rect x="0" y="0" width="1" height="1" fill="url(#vsgg)" /></svg>';

    svg = 'url(data:image/svg+xml;base64,' + $.base64.encode(svg) + ')';

    return svg;
  }

  function getLinearGradientData(dataset, which) {
    if (typeof which === 'undefined') {
      which = 'all';
    }

    var gradient_direction = getPreference('gradient_direction', dataset),
        noprefix,
        webkit,
        ms,
        oldwebkit,
        svg,
        filter,
        averagebgcolor,
        repeating = '';

    if (getPreference('gradient_repeat', dataset) === 'on') {
      repeating = 'repeating-';
    }

    if (gradient_direction === 'angle') {
      var angle = getPreference('linear_gradient_angle', dataset);

      if (which === 'all' || which === 'noprefix') {
        noprefix = repeating + 'linear-gradient(' + angle + 'deg' + getStopPointsString(dataset);
      }
      if (which === 'all' || which === 'webkit') {
        webkit = '-webkit-' + repeating + 'linear-gradient(' + (Math.abs(angle - 450) % 360) + 'deg' + getStopPointsString(dataset);
      }
      if (which === 'all' || which === 'ms') {
        ms = '-ms-' + repeating + 'linear-gradient(' + (Math.abs(angle - 450) % 360) + 'deg' + getStopPointsString(dataset);
      }
    }
    else {
      if (which === 'all' || which === 'noprefix') {
        noprefix = repeating + 'linear-gradient(to ' + gradient_direction + getStopPointsString(dataset);
      }
      if (which === 'all' || which === 'webkit') {
        webkit = '-webkit-' + repeating + 'linear-gradient(' + webkitGradientDirectionKeyword(gradient_direction) + getStopPointsString(dataset);
      }
      if (which === 'all' || which === 'ms') {
        ms = '-ms-' + repeating + 'linear-gradient(' + webkitGradientDirectionKeyword(gradient_direction) + getStopPointsString(dataset);
      }
    }

    if (which === 'all' || which === 'oldwebkit') {
      oldwebkit = getOldWebkitLinear(dataset, gradient_direction);
    }
    if (which === 'all' || which === 'svg') {
      svg = getSvgLinear(dataset, gradient_direction);
    }
    if (which === 'all' || which === 'filter') {
      filter = getIEFilter(dataset);
    }
    if (which === 'all' || which === 'averagebgcolor') {
      averagebgcolor = getWeightedAverageColor(dataset);
    }

    var r = {
      valid: true,
      noprefix: noprefix,
      webkit: webkit,
      ms: ms,
      oldwebkit: oldwebkit,
      svg: svg,
      filter: filter,
      averagebgcolor: averagebgcolor
    };

    return r;
  }

  function getFallbackWidth() {
    var r = getConfig('config_fallbackwidth');

    if (!r) {
      return elements.preview.width();
    }
    else {
      return parseInt(r);
    }
  }

  function getFallbackHeight() {
    var r = getConfig('config_fallbackheight');

    if (!r) {
      return elements.preview.height();
    }
    else {
      return parseInt(r);
    }
  }

  function getOldWebkitRadial(dataset) {
    var oldwebkit = '-webkit-gradient(radial, ',
        stoppoints = getOldWebkitStopPointsData(dataset),
        r = getPreference('gradient_size', dataset),
        gph = getPreference('gradient_position_horizontal', dataset),
        gpv = getPreference('gradient_position_vertical', dataset);

    if (gph === 'explicit') {
      gph = getPreference('gradient_position_horizontal_value', dataset);
      if (getPreference('gradient_position_horizontal_unit', dataset) === '%') {
        gph = gph + '%';
      }
    }

    if (gpv === 'explicit') {
      gpv = getPreference('gradient_position_vertical_value', dataset);
      if (getPreference('gradient_position_vertical_unit', dataset) === '%') {
        gpv = gpv + '%';
      }
    }

    if (r !== 'explicit') {
      r = getRadius(gph, gpv, dataset);

      var previewwidth = getFallbackWidth(),
          previewheight = getFallbackHeight();

      r = Math.round(r / 100 * Math.sqrt(previewwidth * previewwidth + previewheight * previewheight));
    }
    else {
      r = getPreference('gradient_size_value', dataset);

      if (getPreference('gradient_shape', dataset) === 'ellipse') {
        r = Math.round((parseInt(r) + parseInt(getPreference('gradient_size_major_value', dataset))) / 2);
      }
    }

    oldwebkit += gph + ' ' + gpv + ', 0, ' + gph + ' ' + gpv + ', ' + r;

    oldwebkit += stoppoints + ')';

    return oldwebkit;
  }

  function getRadius(xpos, ypos, dataset) {
    var xs, ys;

    if (xpos === 'left') {
      xpos = 0;
    }
    else if (xpos === 'center') {
      xpos = 50;
    }
    else if (xpos === 'right') {
      xpos = 100;
    }

    if (ypos === 'top') {
      ypos = 0;
    }
    else if (ypos === 'center') {
      ypos = 50;
    }
    else if (ypos === 'bottom') {
      ypos = 100;
    }

    xpos = parseInt(xpos);
    ypos = parseInt(ypos);

    switch (getPreference('gradient_size', dataset)) {
      case 'closest-side':
        if (xpos < 50) {
          xs = xpos;
        }
        else {
          xs = 100 - xpos;
        }
        if (ypos < 50) {
          ys = ypos;
        }
        else {
          ys = 100 - ypos;
        }

        return Math.min(xs, ys);

      case 'closest-corner':
        if (xpos < 50) {
          xs = xpos;
        }
        else {
          xs = 100 - xpos;
        }
        if (ypos < 50) {
          ys = ypos;
        }
        else {
          ys = 100 - ypos;
        }

        return Math.sqrt(xs * xs + ys * ys);

      case 'farthest-side':
        if (xpos < 50) {
          xs = 100;
        }
        else {
          xs = xpos;
        }
        if (ypos < 50) {
          ys = 100 - ypos;
        }
        else {
          ys = ypos;
        }

        return Math.max(xs, ys);

      case 'farthest-corner':
        if (xpos < 50) {
          xs = 100;
        }
        else {
          xs = xpos;
        }
        if (ypos < 50) {
          ys = 100 - ypos;
        }
        else {
          ys = ypos;
        }

        return Math.sqrt(xs * xs + ys * ys);

      default:
        if (xpos > 50) {
          xs = xpos;
        }
        else {
          xs = 100 - xpos;
        }
        if (ypos > 50) {
          ys = ypos;
        }
        else {
          ys = 100 - ypos;
        }

        var r;

        if (getPreference('gradient_size_unit', dataset) === '%') {
          if (getPreference('gradient_shape', dataset) === 'circle') {
            r = getPreference('gradient_size_value', dataset);
          }
          else {
            r = (parseInt(getPreference('gradient_size_value', dataset)) + parseInt(getPreference('gradient_size_major_value'))) / 2;
          }
        }
        else {
          if (getPreference('gradient_shape', dataset) === 'circle') {
            r = Math.round(parseInt(getPreference('gradient_size_value', dataset)) / ((getFallbackWidth() + getFallbackHeight()) / 2) * 1000) / 10;
          }
          else {
            var avgsize = (parseInt(getPreference('gradient_size_value', dataset)) + parseInt(getPreference('gradient_size_major_value'))) / 2;
            r = Math.round(avgsize / ((getFallbackWidth() + getFallbackHeight()) / 2) * 1000) / 10;
          }
        }

        return r;
    }
  }

  function getSvgRadial(dataset) {
    var svg = '',
        svgstoppoints = getSvgStopPointsData(dataset),
        x,
        y,
        r,
        xpos,
        ypos;

    x = getPreference('gradient_position_horizontal', dataset);

    switch (x) {
      case 'explicit':
        x = getPreference('gradient_position_horizontal_value', dataset);
        break;
      case 'left':
        x = 0;
        break;
      case 'center':
        x = 50;
        break;
      case 'right':
        x = 100;
        break;
    }

    y = getPreference('gradient_position_vertical', dataset);

    switch (y) {
      case 'explicit':
        y = getPreference('gradient_position_vertical_value', dataset);
        break;
      case 'top':
        y = 0;
        break;
      case 'center':
        y = 50;
        break;
      case 'bottom':
        y = 100;
        break;
    }

    if (x > 50) {
      xpos = x;
    }
    else {
      xpos = 100 - x;
    }

    if (y > 50) {
      ypos = y;
    }
    else {
      ypos = 100 - y;
    }

    r = getRadius(xpos, ypos, dataset);

    svg = '<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 1 1" preserveAspectRatio="none"><radialGradient id="vsgg" gradientUnits="userSpaceOnUse" cx="' + x + '%" cy="' + y + '%" r="' + r + '%">';

    svg += svgstoppoints;

    svg += '</radialGradient><rect x="-50" y="-50" width="101" height="101" fill="url(#vsgg)" /></svg>';

    svg = 'url(data:image/svg+xml;base64,' + $.base64.encode(svg) + ')';

    return svg;
  }

  function getRadialGradientData(dataset, which) {
    if (typeof which === 'undefined') {
      which = 'all';
    }

    var gradient_shape = getPreference('gradient_shape', dataset),
        size = getPreference('gradient_size', dataset),
        webkitshapeandsize = gradient_shape + ' ' + size,
        gradient_position_horizontal = getPreference('gradient_position_horizontal', dataset),
        gradient_position_vertical = getPreference('gradient_position_vertical', dataset),
        noprefix,
        webkit,
        ms,
        oldwebkit,
        svg,
        filter,
        averagebgcolor,
        repeating = '';

    if (gradient_position_horizontal === 'explicit') {
      gradient_position_horizontal = getValueWithUnit('gradient_position_horizontal', dataset);
    }

    if (gradient_position_vertical === 'explicit') {
      gradient_position_vertical = getValueWithUnit('gradient_position_vertical', dataset);
    }

    if (size === 'explicit') {
      size = getValueWithUnit('gradient_size', dataset);
      if (gradient_shape === 'ellipse') {
        size = size + ' ' + getValueWithUnit('gradient_size_major', dataset);
        webkitshapeandsize = size;
      }
      else {
        webkitshapeandsize = size + ' ' + size;
      }
    }

    if (getPreference('gradient_repeat', dataset) === 'on') {
      repeating = 'repeating-';
    }

    if (which === 'all' || which === 'noprefix') {
      noprefix = repeating + 'radial-gradient(' + gradient_shape + ' ' + size + ' at ' + gradient_position_horizontal + ' ' + gradient_position_vertical + getStopPointsString(dataset);
    }
    if (which === 'all' || which === 'webkit') {
      webkit = '-webkit-' + repeating + 'radial-gradient(' + gradient_position_horizontal + ' ' + gradient_position_vertical + ', ' + webkitshapeandsize + getStopPointsString(dataset);
    }
    if (which === 'all' || which === 'ms') {
      ms = '-ms-' + repeating + 'radial-gradient(' + gradient_position_horizontal + ' ' + gradient_position_vertical + ', ' + webkitshapeandsize + getStopPointsString(dataset);
    }
    if (which === 'all' || which === 'svg') {
      svg = getSvgRadial(dataset);
    }
    if (which === 'all' || which === 'filter') {
      filter = getIEFilter(dataset);
    }
    if (which === 'all' || which === 'averagebgcolor') {
      averagebgcolor = getWeightedAverageColor(dataset);
    }
    if (which === 'all' || which === 'oldwebkit') {
      oldwebkit = getOldWebkitRadial(dataset);
    }

    var r = {
      valid: checkRadialGradientValidity(gradient_shape, size, gradient_position_horizontal, gradient_position_vertical),
      noprefix: noprefix,
      oldwebkit: oldwebkit,
      svg: svg,
      webkit: webkit,
      ms: ms,
      filter: filter,
      averagebgcolor: averagebgcolor
    };

    return r;
  }

  function getGradientData() {
    if (getPreference('gradient_type') === 'linear') {
      return getLinearGradientData();
    }
    else {
      return getRadialGradientData();
    }
  }

  function refreshCssOutput() {
    var visiblecount = getVisibleColorStopsCount(),
        sp = getVisibleColorStops(),
        selector = getConfig('config_cssselector');

    if (visiblecount > 1) {
      var gradientdata = getGradientData();

      if (gradientdata.valid) {
        var css = {
          bgcolor: '    background-color: ' + getRenderColor(gradientdata.averagebgcolor) + ';\n',
          svg: '    /* IE9, iOS 3.2+ */\n    background-image: ' + gradientdata.svg + ';\n',
          oldwebkit: '    background-image: ' + gradientdata.oldwebkit + ';\n',
          androidhack: '    /* Android 2.3- hack (needed for the actual radial gradient) */\n    background-image: ' + gradientdata.svg + ',\n        ' + gradientdata.oldwebkit + ';\n',
          webkit: '    /* Android 2.3 */\n    background-image: ' + gradientdata.webkit + ';\n',
          ms: '    background-image: ' + gradientdata.ms + ';\n',
          noprefix: '    /* IE10+ */\n    background-image: ' + gradientdata.noprefix + ';\n',
          filter: '\n/* IE8- CSS hack */\n@media ' + '\\' + '0screen' + '\\' + ',screen' + '\\' + '9 {\n    ' + selector + ' {\n        filter: ' + gradientdata.filter + ';\n    }\n}'
        };

        var out = '';

        if (getConfig('config_generation_bgcolor')) {
          out += css.bgcolor;
        }

        if (getConfig('config_generation_svg') && getConfig('config_generation_oldwebkit')) {
          if (oldWebkitCompatible()) {
            out += css.svg;
            out += css.oldwebkit;
          }
          else {
            out += css.svg;
            out += css.androidhack;
          }
        }
        else {
          if (getConfig('config_generation_svg')) {
            out += css.svg;
          }

          if (getConfig('config_generation_oldwebkit')) {
            out += css.oldwebkit;
          }
        }

        if (getConfig('config_generation_webkit')) {
          out += css.webkit;
        }

        out += css.noprefix;

        if (getConfig('config_generation_ms')) {
          out += css.ms;
        }
        var gradient_bg = out;
        
        // Add custom border and shadow to original output result
        var mine_color = getRenderColor(gradientdata.averagebgcolor);
        cssoutput = selector + ' {\n' + out + 'border : solid 1px ' + mine_color + ';box-shadow : 2px 2px 3px ' + mine_color + '; }\n';
        
        // Here is custom added output for site design - styles for template redlabel
        var more_brigness_color = increase_brightness(mine_color, '20');
        var more_more_brigness_color = increase_brightness(mine_color, '50');
        cssoutput += '.mine-color, .btn-inner-search { background-color:' + mine_color + '; }\n';
        cssoutput += '.button-more::before { border-color: transparent ' + mine_color + '; }\n';
        cssoutput += '.btn-go-search:active,.btn-go-search:focus, .btn-go-search:hover, .button-more:hover, .button-more:focus, .button-more:hover { background-color: ' + more_brigness_color + '; }\n';
        cssoutput += 'div.filter-sidebar .title, .title.alone {border-bottom: 3px solid ' + more_more_brigness_color + '; }\n';
        cssoutput += 'div.filter-sidebar .title span, .title.alone span {border-bottom : 3px solid ' + mine_color + '; }\n';
        
        // styles for template clothesshop
        cssoutput += '.cloth-bg-color {background-color:' + mine_color + ';}\n';
        cssoutput += '.cloth-color {color:' + mine_color + ';}\n';
        cssoutput += '.cloth--border-color {border-color:' + mine_color + ';}\n';
        cssoutput += '.cloth-border-top-color {border-top-color: ' + mine_color + ';}\n';
        cssoutput += '.navbar.cloth .navbar-nav li.active a { color:' + mine_color + ';}\n';
        cssoutput += '.navbar.cloth .navbar-nav li a:hover, .navbar.cloth .navbar-nav li a:focus {background-color:transparent !important; color:' + mine_color + ';}\n';
        cssoutput += '.navbar.cloth .navbar-nav li:hover, .navbar.cloth .navbar-nav li.active {border-top:3px solid; border-top-color: ' + mine_color + ';}\n';
        cssoutput += '#small_carousel .product-list div.add-to-cart, #small_carousel .product-list .info-btn {background-color: ' + mine_color + '; }\n';
        cssoutput += '.products .product-list div.add-to-cart, .products .product-list .info-btn { background-color: ' + mine_color + ';}\n';
        cssoutput += '.part-label { background-color: ' + mine_color + ';}\n';
        cssoutput += '.pagination li a { color:' + mine_color + ';}\n';
        cssoutput += '.pagination li.active a {background-color: ' + mine_color + '; border-color:' + mine_color + '; }\n';
        cssoutput += '.list li a {background-color:' + mine_color + ';}\n';
        cssoutput += '#home-slider .carousel-indicators .active, #small_carousel .carousel-indicators .active {background-color: ' + mine_color + ';}\n';
        cssoutput += '.btn-blue-round {' + gradient_bg + '}\n';
        cssoutput += '.my-basket span.sum-scope {color:' + mine_color + ';}\n';
        cssoutput += '.search .btn-red { border-bottom: 1px solid '+more_more_brigness_color+  '; border-right: 1px solid ' +more_more_brigness_color+ ' ; border-left: 1px solid '+more_more_brigness_color+' ;}\n';
        cssoutput += '#small_carousel .product-list h2 a {color:' + mine_color + ';}\n';
        cssoutput += '#home-slider .item h1 a {color:' + mine_color + ';}\n';

        if (getConfig('config_generation_iefilter')) {
          cssoutput = cssoutput + css.filter;
        }
      }
      else {
        if (visiblecount > 0) {
          cssoutput = selector + ' {\n    background-color: ' + getRenderColor(sp[sp.length - 1]) + ';\n}';
        }
        else {
          cssoutput = selector + ' {\n    background-color: transparent;\n}';
        }
      }
    }
    else if (visiblecount === 1) {
      alert('Choose more than one color!');
    }
    else {
      cssoutput = selector + ' {\n    background-color: transparent;\n}';
    }
  }

  function updateCssOutput() {
    refreshCssOutput();

    elements.cssoutput.text(cssoutput);

    elements.cssoutput.html(cssoutput);
    elements.cssoutput.data('output', cssoutput);
  }

  function renderLastColor(targetelement, dataset) {
    if (typeof targetelement === 'undefined') {
      targetelement = elements.preview;
    }

    var color = 'transparent';
    var colorStops = getColorStops(dataset);

    orderColorStops(colorStops);

    for (var i = 0; i < colorStops.length; i++) {
      var el = colorStops[i];

      if (el.markForDeath) {
        continue;
      }

      color = getRenderColor(el);
    }

    if (targetelement) {
      targetelement.css('background', color);

      if (targetelement.is(elements.preview)) {
        elements.currentpreset.css('background', color);
      }
    }
    else {
      elements.preview.css('background', color);
      elements.currentpreset.css('background', color);
    }
  }

  function getColorStops(dataset) {
    if (typeof dataset === 'undefined') {
      return colorStops;
    }
    else {
      return dataset.colorStops;
    }

  }

  function getVisibleColorStopsCount(dataset) {
    var colorStops = getColorStops(dataset),
        pointscount = 0;

    for (var i = 0; i < colorStops.length; i++) {
      if (colorStops[i].markForDeath) {
        continue;
      }

      ++pointscount;
    }

    return pointscount;
  }

  function renderGradient(targetelement, dataset) {
    if (typeof targetelement === 'undefined') {
      targetelement = elements.preview;
    }

    if (getVisibleColorStopsCount(dataset) < 2) {
      renderLastColor(targetelement, dataset);
      return;
    }

    var gradient_type = getPreference('gradient_type', dataset);

    switch (gradient_type) {
      case 'linear':
        renderLinearGradient(targetelement, dataset);
        break;
      case 'radial':
        renderRadialGradient(targetelement, dataset);
        break;
      default:
        console.log('Unknown gradient type: ' + gradient_type);
        break;
    }
  }

  function updatePreview(targetelement, gradientdata, dataset) {
    if (typeof targetelement === 'undefined') {
      targetelement = elements.preview;
    }

    var rendermode = getCurrentRendermode();

    switch (rendermode) {
      case 'noprefix':
        targetelement.css('background-image', gradientdata.noprefix);
        break;
      case 'webkit':
        targetelement.css('background-image', gradientdata.webkit);
        break;
      case 'ms':
        targetelement.css('background-image', gradientdata.ms);
        break;
      case 'svg': // can not repeat, radial can be only a covering ellipse (maybe there is a workaround, need more investigation)
        targetelement.css('background-image', gradientdata.svg);
        break;
      case 'oldwebkit':   // can not repeat, no percent size with radial gradient (and no ellipse)
        targetelement.css('background-image', gradientdata.oldwebkit);
        break;
      case 'filter':
        targetelement.css('filter', gradientdata.filter);
        break;
      case 'averagebgcolor':
        /* falls through */
      default:
        targetelement.css('background-color', getWeightedAverageColor(dataset));
        break;
    }

  }

  function renderLinearGradient(targetelement, dataset) {
    if (typeof targetelement === 'undefined') {
      targetelement = elements.preview;
    }

    var gradientdata = getLinearGradientData(dataset, getCurrentRendermode());

    if (gradientdata.stoppoints === false) {
      renderLastColor(targetelement, dataset);
      renderLastColor(elements.currentpreset, dataset);
      return;
    }

    updatePreview(targetelement, gradientdata, dataset);

    if (targetelement.is(elements.preview)) {
      updatePreview(elements.currentpreset, gradientdata, dataset);
    }
  }

  function renderRadialGradient(targetelement, dataset) {
    if (typeof targetelement === 'undefined') {
      targetelement = elements.preview;
    }

    var gradientdata = getRadialGradientData(dataset, getCurrentRendermode());

    if (!gradientdata.valid || gradientdata.stoppointsstring === false) {
      renderLastColor(targetelement, dataset);
      renderLastColor(elements.currentpreset, dataset);
      return;
    }

    updatePreview(targetelement, gradientdata, dataset);

    if (targetelement.is(elements.preview)) {
      updatePreview(elements.currentpreset, gradientdata, dataset);
    }
  }

  function getWeightedAverageColor(dataset) {
    var stops = getVisibleColorStops(dataset);

    if (stops.length === 1) {
      return stops[0].color;
    }

    var min = stops[0].position,
        max = stops[stops.length - 1].position,
        length = max - min,
        sumr = 0,
        sumg = 0,
        sumb = 0,
        suma = 0,
        i;

    for (i = 0; i < stops.length; i++) {
      if (max > 100 || getPreference('gradient_repeat', dataset) === 'on') {
        stops[i].percentpos = (stops[i].position - min) / length;
      }
      else {
        stops[i].percentpos = parseFloat(stops[i].position) / 100;
      }

      stops[i].rgb = tinycolor(stops[i].color).toRgb();
    }

    for (i = 0; i < stops.length; i++) {
      var prevpos = i > 0 ? stops[i - 1].percentpos : 0,
          nextpos = i < stops.length - 1 ? stops[i + 1].percentpos : 1;

      stops[i].weight = (stops[i].percentpos - prevpos) / 2 + (nextpos - stops[i].percentpos) / 2;
    }

    stops[0].weight += stops[0].percentpos / 2;
    stops[stops.length - 1].weight += (1 - stops[stops.length - 1].percentpos) / 2;

    for (i = 0; i < stops.length; i++) {
      sumr = sumr + stops[i].rgb.r * stops[i].weight;
      sumg = sumg + stops[i].rgb.g * stops[i].weight;
      sumb = sumb + stops[i].rgb.b * stops[i].weight;
      suma = suma + stops[i].rgb.a * stops[i].weight;
    }

    var rgba = {
      r: sumr,
      g: sumg,
      b: sumb,
      a: suma
    };

    var averagecolor = rgba.a === 1 ? tinycolor(rgba).toHexString() : tinycolor(rgba).toRgbString();

    return averagecolor;
  }

  /*
   * Check if gradient has zero length due to a webkit bug:
   * https://bugs.webkit.org/show_bug.cgi?id=121642
   * https://code.google.com/p/chromium/issues/detail?id=295126
   */
  function checkRadialGradientValidity(shape, size, gradient_position_horizontal, gradient_position_vertical) {
    if (size.charAt(0) === '0' || size.indexOf(' 0') > -1) {
      return false;
    }

    var zeropos = 0;

    if (gradient_position_horizontal.charAt(0) === '0') {
      zeropos++;
    }

    if (gradient_position_vertical.charAt(0) === '0') {
      zeropos++;
    }

    if ((size.match(/(closest-corner)/i)) &&
        (gradient_position_horizontal.match(/(left|right)/i) && gradient_position_vertical.match(/(top|bottom)/i))) {
      return false;
    }

    if ((size.match(/(closest-side)/i)) &&
        (gradient_position_horizontal.match(/(left|right)/i) || gradient_position_vertical.match(/(top|bottom)/i))) {
      return false;
    }

    if (size === 'closest-side' && zeropos > 0) {
      return false;
    }

    if (size === 'closest-corner' && zeropos > 1) {
      return false;
    }

    if ((shape.match(/(ellipse)/i)) && (size.match(/(closest-corner)/i))) {
      if (zeropos > 0 || (gradient_position_horizontal.match(/(left|right)/i) || gradient_position_vertical.match(/(top|bottom)/i))) {
        return false;
      }
    }

    return true;
  }

  function hideColorPopups() {
    $('input.css-gradient-editor-stop-point-color', elements.colorstopslist).blur();
  }

  function loadDefaultSwatches() {
    for (var i = 0; i < settings.defaultswatches.length; i++) {
      swatches.push(convertToNewGradientFormat(settings.defaultswatches[i]));
    }
  }

  function convertToNewGradientFormat(data) {
    var oldformat = data.split('|');

    if (oldformat.length === 2) {
      oldformat[1] = replaceAll('%', '%25', replaceAll('%25', '%', oldformat[1]));

      data = replaceAll(',', '&', oldformat[0]) + '&sp=';
      data += replaceAll('/', '_', replaceAll(',', '__', oldformat[1]));
    }

    data = data.replace(/\+/g, '%20');

    return data;
  }

  function loadSwatches() {
    swatches = [];

    if (settings.customswatchesnameprefix) {
      var customswatches = [];

      try {
        customswatches = JSON.parse(localStorage.getItem('gradientswatches-' + settings.customswatchesnameprefix));
        if (customswatches) {
          for (var i = 0; i < customswatches.length; i++) {
            swatches.push(convertToNewGradientFormat(customswatches[i]));
          }
        }
        else {
          loadDefaultSwatches();
        }
      }
      catch (err) {
        console.log(err);
        loadDefaultSwatches();
      }
    }
    else {
      loadDefaultSwatches();
    }
  }

  function renderSwatches() {
    loadSwatches();

    elements.swatches.html('');

    if (swatches instanceof Array) {
      for (var i = 0; i < swatches.length; i++) {
        var swatch = swatches[i];

        var span = $('<span></span>');
        var button = $('<div class="btn btn-default css-gradient-editor-preset"></div>').data('gradient', swatch);

        button.append(span);

        elements.swatches.append($('<li></li>').append(button));

        renderGradient(span, parseGradientPermalink(swatch));
      }
    }

    findActualGradientsSwatch();
  }

  function findActualGradientsSwatch() {
    var found = false;

    currentgradient = getGradientQueryString();

    $('.css-gradient-editor-preset', elements.swatches).filter(function() {
      var gradient = $(this).data('gradient');

      if (gradient === currentgradient) {
        found = true;

        var currentswatch = $(this).parent();

        if (!currentswatch.is(elements.actualswatch)) {
          if (elements.actualswatch) {
            elements.actualswatch.removeClass('actual');
          }
          elements.actualswatch = currentswatch;
          currentswatch.addClass('actual');
        }
      }
    });

    if (!found) {
      if (elements.actualswatch) {
        elements.actualswatch.removeClass('actual');
        elements.actualswatch = false;
      }
    }

    if (elements.actualswatch) {
      elements.swatches_add.prop('disabled', true);
      elements.swatches_remove.prop('disabled', false);
    }
    else {
      elements.swatches_add.prop('disabled', false);
      elements.swatches_remove.prop('disabled', true);
    }
  }

  function storeSwatches() {
    try {
      localStorage.setItem('gradientswatches-' + settings.customswatchesnameprefix, JSON.stringify(swatches));
    }
    catch (err) {
    }
  }

  function setConfig(name, value) {
    try {
      localStorage.setItem('userdata-' + name, JSON.stringify(value));
    }
    catch (err) {
    }
  }

  function getConfig(name) {
    try {
      var r = JSON.parse(localStorage.getItem('userdata-' + name));

      if (r === null || r === '') {
        r = defaultconfig[name];
      }

      return r;
    }
    catch (err) {
      return defaultconfig[name];
    }
  }

  function gradientSwatchIsUnique(gradient) {
    return (swatches.indexOf(gradient) === -1 && swatches.indexOf(convertToNewGradientFormat(gradient)) === -1);
  }

  function addCurrentGradientToSwatches() {
    addGradientToSwatches(currentgradient);
  }

  function addGradientToSwatches(gradient) {
    var parsed = parseGradientPermalink(gradient);

    if (!parsed && !parsed.hasOwnProperty('colorStops')) {
      return false;
    }

    if (!gradientSwatchIsUnique(gradient)) {
      return false;
    }

    swatches.unshift(convertToNewGradientFormat(gradient));

    storeSwatches();

    $(document).trigger('cssgradienteditor.changeswatches');
  }

  function importGradients(jsontext) {
    try {
      var toimport = jQuery.parseJSON(jsontext);

      if (!toimport instanceof Array) {
        return false;
      }

      var length = toimport.length;

      for (var i = 0; i < length; i++) {
        addGradientToSwatches(toimport[i]);
      }
    }
    catch (e) {
      console.log(e);
      return false;
    }
  }

  function removeActualGradientFromSwatches() {
    var index = swatches.indexOf(currentgradient);

    if (index !== -1) {
      swatches.splice(index, 1);

      storeSwatches();
      $(document).trigger('cssgradienteditor.changeswatches');
    }
  }

  function refreshUndoButtons() {
    if (undoCanStepBack()) {
      elements.undobutton.prop('disabled', false);
    }
    else {
      elements.undobutton.prop('disabled', true);
    }

    if (undoCanStepForward()) {
      elements.redobutton.prop('disabled', false);
    }
    else {
      elements.redobutton.prop('disabled', true);
    }
  }

  function initUndo() {
    undoArray = [];
    undoIndex = -1;

    undoSaveState();
  }

  function undoSaveState() {
    clearTimeout(undoTimeout);

    if (!gradientready) {
      return;
    }

    updateToolbar();
    updateCssOutput();

    if (checkiflayoutcanchange) {
      setupLayout();
    }

    if (undoIndex > -1 && currentgradient === undoArray[undoIndex]) {
      return;
    }

    undoArray[++undoIndex] = currentgradient;

    if (undoArray.length > undoIndex + 1) {
      undoArray = undoArray.slice(0, undoIndex + 1);
    }

    refreshUndoButtons();

    if (gradientAutosave) {
      setConfig('lastGradient', currentgradient);
    }
  }

  function undoBack() {
    if (undoIndex <= 0) {
      return;
    }

    loadGradient(undoArray[--undoIndex], false);

    refreshUndoButtons();
  }

  function undoForward() {
    if (undoIndex + 1 >= undoArray.length) {
      return;
    }

    loadGradient(undoArray[++undoIndex], false);

    refreshUndoButtons();
  }

  function undoCanStepBack() {
    return undoIndex > 0;
  }

  function undoCanStepForward() {
    return undoIndex < undoArray.length - 1;
  }

  function oldWebkitCompatible(dataset) {
    if (getPreference('gradient_type', dataset) === 'linear') {
      return true;
    }

    if (getPreference('gradient_shape', dataset) === 'ellipse') {
      return false;
    }

    if (getPreference('gradient_size', dataset) !== 'explicit') {
      return false;
    }

    return true;
  }

  function initQR() {
    qrcode = new QRCode('permalinkqr', {
      text: 'http://www.virtuosoft.eu/css-gradient-generator/',
      width: 280,
      height: 280,
      colorDark: '#000000',
      colorLight: '#ffffff',
      correctLevel: QRCode.CorrectLevel.H
    });
  }

  function updateQR() {
    clearTimeout(qrupdatetimeout);

    qrupdatetimeout = setTimeout(function() {
      var url = 'http://www.virtuosoft.eu/tools/css-gradient-generator/?' + elements.permalink.data('querystring');

      try {
        qrcode.makeCode(url);
      }
      catch (e) {
      }
    }, 500);
  }

  function detectCompatibilityLevel(dataset) {
    var needs = {
      advanced: false,
      expert: false
    },
    cs = getVisibleColorStops(dataset);

    if (cs.length !== 2) {
      needs.advanced = true;
    }
    else if (cs[0].position !== '0' || cs[1].position !== '100' || cs[0].unit !== '%' || cs[1].unit !== '%') {
      needs.advanced = true;
    }

    if (getPreference('gradient_repeat', dataset) === 'on') {
      needs.advanced = true;
    }

    switch (getPreference('gradient_type', dataset)) {
      case 'linear':
        var gd = getPreference('gradient_direction', dataset);

        if (gd === 'angle') {
          needs.expert = true;
        }

        if (gd === 'top left' || gd === 'top right' || gd === 'bottom left' || gd === 'bottom right') {
          needs.advanced = true;
        }

        break;

      case 'radial':

        needs.advanced = true;

        if (getPreference('gradient_shape', dataset) === 'circle') {
          needs.expert = true;
        }

        if (getPreference('gradient_size', dataset) === 'explicit') {
          needs.expert = true;
        }

        if (getPreference('gradient_position_horizontal', dataset) === 'explicit') {
          needs.expert = true;
        }

        if (getPreference('gradient_position_vertical', dataset) === 'explicit') {
          needs.expert = true;
        }

        break;
    }

    if (needs.expert) {
      return LAYOUT_EXPERT;
    }

    if (needs.advanced) {
      return LAYOUT_ADVANCED;
    }

    return LAYOUT_SIMPLE;
  }

  function forceLayoutChange() {
    var desiredlayout = getConfig('config_layout');

    if (desiredlayout >= layout) {
      return;
    }

    if (getPreference('gradient_type') === 'linear') {
      if (getPreference('gradient_direction') === 'angle') {
        setPreference('gradient_direction', simplifyDirection());
      }
    }
    else {
      setPreference('gradient_shape', 'ellipse');

      if (getPreference('gradient_size') === 'explicit') {
        setPreference('gradient_size', 'farthest-corner');
      }
      if (getPreference('gradient_position_horizontal') === 'explicit') {
        setPreference('gradient_position_horizontal', 'center');
      }
      if (getPreference('gradient_position_vertical') === 'explicit') {
        setPreference('gradient_position_vertical', 'center');
      }
    }

    if (desiredlayout === 0) {
      setPreference('gradient_repeat', 'off');
      setPreference('gradient_type', 'linear');
      setPreference('gradient_direction', simplifyDirection());

      var sp = getVisibleColorStops(),
          from,
          to;

      if (sp.length >= 2) {
        from = $.extend({}, sp[0]),
            to = $.extend({}, sp[sp.length - 1]);

        from.position = 0;
        from.unit = '%';

        to.position = 100;
        to.unit = '%';
      }
      else if (sp.length === 1) {
        from = $.extend({}, sp[0]),
            to = {
              position: 100,
              unit: '%',
              color: lastSelectedColor
            };

        from.position = 0;
        from.unit = '%';
      }
      else {
        from = {
          position: 0,
          unit: '%',
          color: lastSelectedColor
        },
        to = {
          position: 100,
          unit: '%',
          color: lastSelectedColor
        };
      }

      removeAllColorStops();

      addColorStop(from);
      addColorStop(to);
    }

    updateInputValues();
    initControllers();
    renderAll();

    setupLayout();
  }
};
