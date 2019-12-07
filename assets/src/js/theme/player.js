

let _players = [];

// HTML5 Video events
const _events = [
  'abort',
  'canplay',
  'cajnplaythrough',
  'durationchange',
  'emptied',
  'ended',
  'loadeddata',
  'loadedmetadata',
  'loadstart',
  'pause',
  'play',
  'playing',
  'progress',
  'ratechange',
  'seeked',
  'seeking',
  'stalled',
  'suspend',
  'timeupdate',
  'volumnechange',
  'waiting'
];

const _codecs = {
    ogg:  'video/ogg; codecs="theora"',
    h264: 'video/mp4; codecs="avc1.42E01E"',
    webm: 'video/webm; codecs="vp8, vorbis"',
    vp9:  'video/webm; codecs="vp9"',
    hls:  'application/x-mpegURL; codecs="avc1.42E01E"'
};

const _idle = 2000;

class Player
{
  constructor(index, element)
  {
    // ID selector or jQuery element
    this.element = element;

    // Video element, get HTML dom element with this.video[0]
    this.video   = $(element);

    // Create unique id for player
    this.id = 'kp-player-' + index;

    this.src = this.video.attr('src');

    // XHR for loading video blob
    this.xhr = new XMLHttpRequest();
    this.xhr.responseType = 'arraybuffer';
    this.xhr.onload = this.onVideoLoad.bind(this);

    // State defaults
    this.loaded    = false;
    this.paused    = true;
    this.playing   = false;
    this.ended     = false;
    this.muted     = false;
    this.idleTimer = false;

    // Wrap video
    this.video.wrap($('<div/>', { class: 'kp-player-container', id: this.id } ));

    // Get player container (root)
    this.container = $(this.video.parent());

    // Remove browser controls
    this.video.removeAttr('controls');
    
    // Create console overlay
    this.createConsole();

    // Create control bar
    this.createControlBar();

    // Create control screen
    this.createControlScreen();

    // Add layers
    this.container.prepend(this.controlBar, this.controlScreen, this.console);

    // Log all events
    this.video.on( _events.join(' '), this.videoEvent.bind(this));

    // Add listeners
    this.video.on( 'timeupdate', this.onTimeUpdate.bind(this));
    this.video.on( 'ended', this.onVideoEnded.bind(this) );
    this.video.on( 'canplay', this.onVideoCanPlay.bind(this) );
    this.video.on( 'loadedmetadata', this.onVideoLoadMeta.bind(this));

    // Show/Hide controls
    this.container.on('mouseleave', this.onMouseLeave.bind(this));
    this.container.on('mousemove', this.onMouseMove.bind(this));



    // Load the video
    this.load();
  }

  /**
   * Load video from src
   */
  load()
  {
    if( ! this.src ) return console.warn('Empty video source!');
    this.xhr.open('GET', this.src);
    this.xhr.send();
  }

  /**
   * XHR onload callback
   */
  onVideoLoad()
  {
    if( this.xhr.status == 200 )
    {
      this.video[0].src = window.URL.createObjectURL( new Blob([this.xhr.response], { type: 'video/mp4'} )); 
    }
  }

  getPreferredCodec()
  {
    $.each(['webm','mp4'], function(i,codec){
      if( this.supportsCodec(codec) == 'probably' ) return codec;
    }.bind(this));
  }

  /**
   * Idle timer, to hide controls after timer ends
   */
  startIdleTimer()
  {
    this.idleTimer = setTimeout( this.hideControls.bind(this), _idle );
  }

  /**
   * Cancel timer on mousemove event
   */
  cancelIdleTimer()
  {
    if(this.idleTimer) clearTimeout(this.idleTimer);
  }

  onMouseLeave(e)
  {
    this.startIdleTimer();
  }

  onMouseMove(e)
  {
    this.cancelIdleTimer();
    this.showControls();
    this.startIdleTimer();
  }

  hideControls()
  {
    this.ui.controlscreen.addClass('hide');
    this.ui.controlbar.addClass('hide');
  }

  showControls()
  {
    this.ui.controlscreen.removeClass('hide');
    this.ui.controlbar.removeClass('hide');
  }

  supportsCodec( codec )
  {
    return this.video[0].canPlayType( _codecs[codec] );
  }

  /**
   * Create debug console screen
   */
  createConsole()
  {
    this.console = $('<div/>', { class: 'kp-player-console' } );

    if( this.video.data('debug') == 1 )
    {
      this.console.css('opacity','1');
    }
  }

  /**
   * Create the control screen
   */
  createControlScreen()
  {
    this.controlScreen = $('<div/>', { class:'kp-player-controlscreen'});

    const controlScreenLoader = $('<div/>', { class: 'kp-player-controlscreen-loader'}).html(this.loaderIcon());
    const controlScreenPlay   = $('<i/>', { class: 'fa fa-play'} ).css('display','none');

    this.controlScreen.append(controlScreenLoader, controlScreenPlay );

    this.controlScreen.on('click', this.onPlayButtonClick.bind(this) );
  }

  /**
   * Loader icon spinner
   */
  loaderIcon()
  {
    return '<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';
  }

  /**
   * Create the control bar
   */
  createControlBar()
  {
    this.controlBar = $('<div/>', { class:'kp-player-controlbar'});

    this.controlBar.append( this.createPlayButton() );
    this.controlBar.append( this.createVolumeButton() );
    this.controlBar.append( this.createScrubber() );

    // FullScreen Button (if supported)
    if( this.fullScreenSupported() )
    {
      this.controlBar.append( this.createFSButton() );
    }

    return;
  }

  /**
   * Create play button
   */
  createPlayButton()
  {
    this.playButton = $('<button/>', { class:'kp-player-btn-play'} );
    this.playButton.html('<i class="fa fa-play"></i>');
    this.playButton.attr('title','Play');
    this.playButton.on('click', this.onPlayButtonClick.bind(this));

    return this.playButton;
  }

  /**
   * Play button click handler
   */
  onPlayButtonClick(e)
  {
    if( ! this.loaded ) return;

    if( this.playing ) {
      this.pause();
    } else {
      this.play();
    }
  }

  /**
   * Create volume button
   */
  createVolumeButton()
  {
    this.volumeButton = $('<button/>', { class:'kp-player-btn-volume' });
    this.volumeButton.html('<i class="fa fa-volume-up"></i>');
    this.volumeButton.attr('title','Mute');
    this.volumeButton.on('click', this.onVolumeButtonClick.bind(this) );

    return this.volumeButton;
  }

  /**
   * Volume button click handler
   */
  onVolumeButtonClick(e){
    console.log('volume',this.loaded,this.muted);
    if( ! this.loaded ) return;
    this.toggleMute();
  }

  /**
   * Toggle video mute
   */
  toggleMute()
  {
    console.log(this.ui.volicon);
    console.log(this.video[0].volume);

    if( this.muted ) {
      this.video[0].volume = 1;
      this.ui.volicon.removeClass('fa-volume-mute').addClass('fa-volume-up').attr('title','Mute');
      this.muted = false;
    } else {
      this.video[0].volume = 0;
      this.ui.volicon.removeClass('fa-volume-up').addClass('fa-volume-mute').attr('title','Unmute');
      this.muted = true;
    }
  }

  /**
   * Create scrubber bar
   */
  createScrubber()
  {
    this.scrubber = $('<div/>', {class:'kp-player-scrubber'});

    const progress = $('<div/>', {class:'kp-player-progress'});
    progress.append( $('<div/>', {class:'kp-player-progress-text'}) );
    progress.append( $('<div/>', {class:'kp-player-progress-value'}) );

    this.scrubber.append( progress );

    this.scrubber.on('click', this.onScrubberClick.bind(this) );

    return this.scrubber;
  }

  /**
   * Scrubber click handler
   */
  onScrubberClick(e)
  { 
    if( ! this.loaded ) return;

    const pos   = parseFloat(e.pageX);
    const off   = this.ui.scrubber.offset();
    const dur   = parseFloat(this.video[0].duration);
    const width = parseFloat(this.ui.scrubber.outerWidth());
    const seek  = dur * ((pos-off.left)/width);

    this.video[0].currentTime = seek;

  }

  /**
   * Create fullscreen button
   */
  createFSButton()
  {
    this.fsbutton = $('<button/>', { class:'kp-player-btn-fs'} );
    this.fsbutton.html('<i class="fa fa-expand"></i>');
    this.fsbutton.on('click', this.onFSClick.bind(this));
    this.fsbutton.attr('title','Full Screen');

    $(document).on('fullscreenchange', this.onFSChange.bind(this) );

    return this.fsbutton;
  }

  /**
   * Handle fullscreen button click
   */
  onFSClick(e)
  {
    if( ! this.loaded ) return;
    this.setFullScreen( ! this.isFullScreen() );
  }

  /**
   * Handle fullscreen change event
   */
  onFSChange(e)
  {
    const isfs = this.isFullScreen();
    this.ui.fsicon.toggleClass('fa-expand', ! isfs );
    this.ui.fsicon.toggleClass('fa-compress', isfs );
    this.container.toggleClass('is-fullscreen', isfs);
  }

  /**
   * Check if fullscreen is supported
   */
  fullScreenSupported()
  {
   return  !! (document.fullscreenEnabled 
     || document.mozFullScreenEnabled 
     || document.msFullscreenEnabled 
     || document.webkitSupportsFullscreen 
     || document.webkitFullscreenEnabled 
     || document.createElement('video').webkitRequestFullScreen);
  }

  /**
   * Check if currently using fullscreen mode
   */
  isFullScreen()
  {
   return !!(document.fullScreen 
     || document.webkitIsFullScreen 
     || document.mozFullScreen 
     || document.msFullscreenElement 
     || document.fullscreenElement);
  }

  /**
   * Enter/Exit fullscreen mode
   * @type {[type]}
   */
  setFullScreen( full = false )
  {
    if( full ) 
    {
      const elem = this.container[0];

      if (elem.requestFullscreen) elem.requestFullscreen();
      else if (elem.mozRequestFullScreen) elem.mozRequestFullScreen();
      else if (elem.webkitRequestFullScreen) elem.webkitRequestFullScreen();
      else if (elem.msRequestFullscreen) elem.msRequestFullscreen();

    } else {
      if (document.exitFullscreen) document.exitFullscreen();
      else if (document.mozCancelFullScreen) document.mozCancelFullScreen();
      else if (document.webkitCancelFullScreen) document.webkitCancelFullScreen();
      else if (document.msExitFullscreen) document.msExitFullscreen();
    }
  }

  videoEvent(e)
  {
    this.log(e.type);
  }

  onVideoLoadMeta(e)
  {
    this.loaded = true;
  }

  onVideoCanPlay(e)
  {
    this.ui.controlloader.css('display','none');
    this.ui.controlplay.css('display','block');
  }

  onTimeUpdate(e)
  {
    const duration = this.video[0].duration || 0;
    const current  = this.video[0].currentTime || 0;
    const progress = (current*(100/duration)).toFixed(2);

    if( current > 0 ) {
      this.ui.progressValue.css('width',progress+'%');
      this.ui.progressText.html(this.toTimecode((duration-current)));
    }
    
  }

  onVideoEnded(e)
  {
    this.pause();
  }

  toTimecode(t)
  {
    const sec = parseInt(t, 10)
    const h   = Math.floor(sec / 3600)
    const m   = Math.floor(sec / 60) % 60
    const s   = sec % 60

    return [h,m,s]
        .map(v => v < 10 ? "0" + v : v)
        .filter((v,i) => v !== "00" || i > 0)
        .join(":")
  }

  log(msg)
  {
    this.ui.console.append($('<div/>').text(msg));
  }


  play()
  {
    this.video[0].play();
    this.playing = true;
    this.paused  = false;
    this.ui.playicon.removeClass('fa-play').addClass('fa-pause').attr('title','Pause');
    this.container.removeClass('is-paused').addClass('is-playing');
  }

  pause()
  {
    this.video[0].pause();
    this.paused  = true;
    this.playing = false;
    this.ui.playicon.removeClass('fa-pause').addClass('fa-play').attr('title','Play');
    this.container.removeClass('is-playing').addClass('is-paused');
  }

  


  get ui()
  {
    if( ! this._ui ) 
    {
      this._ui = {
        console: this.container.find('.kp-player-console'),
        controlbar: this.container.find('.kp-player-controlbar'),
        controlscreen: this.container.find('.kp-player-controlscreen'),
        controlloader: this.container.find('.kp-player-controlscreen-loader'),
        controlplay: this.container.find('.kp-player-controlscreen .fa-play'),
        play: this.container.find('.kp-player-btn-play'),
        playicon: this.container.find('.kp-player-btn-play i.fa'),
        volume: this.container.find('.kp-player-btn-volume'),
        volicon: this.container.find('.kp-player-btn-volume i.fa'),
        fs: this.container.find('.kp-player-btn-fs'),
        fsicon: this.container.find('.kp-player-btn-fs i.fa'),
        scrubber: this.container.find('.kp-player-scrubber'),
        progress: this.container.find('.kp-player-progress'),
        progressText: this.container.find('.kp-player-progress-text'),
        progressValue: this.container.find('.kp-player-progress-value'),
      }
    }

    return this._ui;
  }




}


export default Player;