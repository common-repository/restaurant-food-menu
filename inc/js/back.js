jQuery(document).ready(function ($) {
  /* helpers */
  function debounce(func, wait, immediate) {
    var timeout
    return function () {
      var context = this,
        args = arguments
      var later = function () {
        timeout = null
        if (!immediate) func.apply(context, args)
      }
      var callNow = immediate && !timeout
      clearTimeout(timeout)
      timeout = setTimeout(later, wait)
      if (callNow) func.apply(context, args)
    }
  }

  /* food editor */
  // upload food image
  $('.rjs_uploadFoodImageButton').click(function () {
    formfield = $('.rjs_ImageUrl').attr('name')
    tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true')
    window.send_to_editor = function (html) {
      imgurl = $(html).attr('src')
      $('.rjs_ImageUrl').val(imgurl)
      $('.rjs_ImageUrlArea').css({
        'background-image': 'url(' + imgurl + ')',
      })
      $('.rjs_ImageUrlArea .rjs_uploadFoodImageButton').hide()
      $('.rjs_ImageUrlArea .rjs_removeFoodImageButton').show()
      tb_remove()
    }
    return false
  })

  // remove food image
  $('.rjs_removeFoodImageButton').click(function () {
    $('.rjs_ImageUrl').val('')
    $('.rjs_ImageUrlArea').css({ 'background-image': 'none' })
    $('.rjs_ImageUrlArea .rjs_uploadFoodImageButton').show()
    $('.rjs_ImageUrlArea .rjs_removeFoodImageButton').hide()
    return false
  })

  /* menu editor */
  // prepare data for saving
  function updateMenuData() {
    let newData = []
    $('.rjs_menuSection').each(function (index) {
      let sectionItems = []
      $(this)
        .find('.rjs_item')
        .each(function () {
          let itemType = $(this).attr('data-type')
          // food
          if (itemType === 'food') {
            let foodId = $(this).attr('data-food-id')
            sectionItems.push({
              type: 'food',
              id: foodId,
            })
          }
          // heading
          if (itemType === 'heading') {
            let headingContent = $(this).find('span').html()
            sectionItems.push({
              type: 'heading',
              content: headingContent,
            })
          }
          // paragraph
          if (itemType === 'paragraph') {
            let paragraphContent = $(this).find('span').html()
            sectionItems.push({
              type: 'paragraph',
              content: paragraphContent,
            })
          }
        })
      newData.push(sectionItems)
    })
    $('.rjs_dataDump').val(JSON.stringify(newData))
    updateSaveButton()
  }

  // update save button
  function updateSaveButton() {
    if (!$(this).hasClass('r_bg-amber-200')) {
      $('.rjs_saveData')
        .removeClass('r_bg-gray-100')
        .addClass('r_bg-amber-200')
        .addClass('hover:r_opacity-80')
        .addClass('r_cursor-pointer')
      $('.rjs_saveData')
        .find('span')
        .removeClass('r_text-gray-400')
        .addClass('r_text-gray-600')
        .addClass('r_animate-pulse')
    }
  }

  // save data with saveData button
  $('.rjs_saveData').click(function () {
    if ($(this).hasClass('r_bg-amber-200')) {
      $('#post').submit()
    }
  })

  // check if need default settings
  let menuSettings
  function initMenuSettings() {
    if ($('.rjs_settingsDump').val().length == 0) {
      let defaultSettings = {
        layout: 2,
        sh_food_images: 'yes',
        food_image_shape: 'rounded',
        food_image_size: 'normal',
      }
      $('.rjs_settingsDump').val(JSON.stringify(defaultSettings))
      menuSettings = defaultSettings
    } else {
      menuSettings = JSON.parse($('.rjs_settingsDump').val())
    }
  }
  initMenuSettings()

  // update settings
  function updateMenuSetting(setting, value) {
    menuSettings[setting] = value
    $('.rjs_settingsDump').val(JSON.stringify(menuSettings))
    updateSaveButton()
  }

  // toggle sidebar
  $('.rjs_toggleSidebar').click(function () {
    $('.rjs_sidebar').toggleClass('re_closedSidebar')
    $('.rjs_editorBody').toggleClass(
      'r_border-gray-200 r_border-r-0 r_border-y-0 r_border-l-4 r_border-dashed'
    )
    $(this)
      .find('span')
      .toggleClass('dashicons-editor-outdent')
      .toggleClass('dashicons-editor-indent')
  })

  // check section notice
  function checkSectionNotice() {
    if ($('.rjs_menuSection').length > 0) {
      $('.rjs_sectionNotice').hide()
    } else {
      $('.rjs_sectionNotice').show()
    }
  }

  // remove section
  $('body').on('click', '.rjs_menuSectionDelete', function () {
    let sectionElement = $(this).closest('.rjs_menuSection')
    // remove all items from section
    sectionElement.find('.rjs_item').each(function () {
      let itemType = $(this).attr('data-type')
      if (itemType === 'food') {
        let foodId = $(this).attr('data-food-id')
        enableFoodItemDragging(foodId)
      }
      $(this).remove()
    })
    sectionElement.remove()
    updateMenuData()
    checkSectionNotice()
  })

  // add a section
  $('body').on('click', '.rjs_menuSectionAdd', function () {
    $('.rjs_menuSectionEmpty')
      .clone(false)
      .removeClass('rjs_menuSectionEmpty r_hidden')
      .addClass('rjs_menuSection r_block')
      .appendTo('.rjs_menuSections')
    initItemSorting()
    updateMenuData()
    checkSectionNotice()
  })

  // search food
  $('.rjs_foodSearch').keypress(function (e) {
    if (e.keyCode === 13) {
      e.preventDefault()
    }
  })
  $('.rjs_foodSearch').keyup(
    debounce(function (e) {
      let searchValue = $(this).val().toLowerCase()
      $('.rjs_foodItemList .rjs_item').each(function () {
        let foodName = $(this).text().toLowerCase()
        if (foodName.indexOf(searchValue) === -1) {
          $(this).hide()
        } else {
          $(this).show()
        }
      })
    }, 400)
  )

  // enable food item dragging
  function enableFoodItemDragging(foodId) {
    $('.rjs_foodItemList .rjs_item[data-food-id=' + foodId + ']')
      .draggable('option', 'disabled', false)
      .removeClass('r_text-gray-400')
  }

  // disable food item dragging
  function disableFoodItemDragging(foodId) {
    $('.rjs_foodItemList .rjs_item[data-food-id=' + foodId + ']')
      .draggable('option', 'disabled', true)
      .addClass('r_text-gray-400')
  }

  // remove item from section
  $('body').on('click', '.rjs_removeItem', function () {
    let itemType = $(this).parent().attr('data-type')
    if (itemType === 'food') {
      let foodId = $(this).parent().attr('data-food-id')
      enableFoodItemDragging(foodId)
    }
    $(this).parent().remove()
    updateMenuData()
  })

  // edit item text
  let isEditingText = false
  function editTextItem(textElement) {
    if (isEditingText === false) {
      isEditingText = true
      let item = textElement
      let itemType = item.attr('data-type')
      let itemTextContentEl = item.find('.rjs_itemTextContent')
      if (itemType === 'heading') {
        let currentContent = itemTextContentEl.html()
        itemTextContentEl.html(
          '<input class="re_item-text-input rjs_itemTextInput r_absolute r_inset-0 r_bg-white" type="text" value="' +
            currentContent +
            '" />'
        )
        item.find('.rjs_removeItem').hide()
        item.find('.rjs_editItemText').hide()
        item.find('.rjs_saveItemText').show()
        item.find('input').focus()
      } else if (itemType === 'paragraph') {
        let currentContent = itemTextContentEl.html()
        itemTextContentEl.html(
          '<textarea class="re_item-text-input rjs_itemTextInput r_relative r_z-80 r_w-full r_resize-none r_h-[100px] r_absolute r_inset-0 r_bg-white" type="text">' +
            currentContent +
            '</textarea>'
        )
        item.find('.rjs_removeItem').hide()
        item.find('.rjs_editItemText').hide()
        item.find('.rjs_saveItemText').show()
        item.find('textarea').focus()
      }
    }
  }

  // edit text on clicking the edit button
  $('body').on('click', '.rjs_editItemText', function () {
    editTextItem($(this).parent())
  })
  $('body').on(
    'dblclick',
    '.rjs_menuSection [data-type="heading"], .rjs_menuSection [data-type="paragraph"]',
    function () {
      if (!isEditingText) {
        editTextItem($(this))
      }
    }
  )

  // save item text
  $('body').on('click', '.rjs_saveItemText', function () {
    let item = $(this).parent()
    let itemType = item.attr('data-type')
    let itemTextContentEl = item.find('.rjs_itemTextContent')
    if (itemType === 'heading') {
      userInput = itemTextContentEl.find('input').val()
      itemTextContentEl.html(userInput)
      item.find('.rjs_removeItem').show()
      item.find('.rjs_editItemText').show()
      item.find('.rjs_saveItemText').hide()
    } else if (itemType === 'paragraph') {
      userInput = itemTextContentEl.find('textarea').val()
      itemTextContentEl.html(userInput)
      item.find('.rjs_removeItem').show()
      item.find('.rjs_editItemText').show()
      item.find('.rjs_saveItemText').hide()
    }
    updateMenuData()
    isEditingText = false
  })

  // save item text with return key
  $('body').on('keypress', '.rjs_itemTextInput', function (e) {
    if (e.keyCode === 13) {
      e.preventDefault()
      $(this).closest('.rjs_item').find('.rjs_saveItemText').click()
    }
  })

  // save by being out of focus
  $('body').on('focusout', '.rjs_itemTextInput', function () {
    $(this).closest('.rjs_item').find('.rjs_saveItemText').click()
  })

  // initialize section sorting (once added to menu)
  function initSectionSorting() {
    $('.rjs_menuSections').sortable({
      handle: '.rjs_menuSectionHandle',
      tolerance: 'pointer',
      stop: function (event, ui) {
        updateMenuData()
      },
    })
  }
  initSectionSorting()

  // initialize item sorting (once in sections)
  function initItemSorting() {
    $('.rjs_menuSection').sortable({
      items: '.rjs_item',
      connectWith: '.rjs_menuSection',
      tolerance: 'pointer',
      receive: function (event, ui) {
        let originSectionEl = $(ui.sender)
        if (!originSectionEl.hasClass('rjs_menuSection')) {
          // food items
          let itemType = $(ui.helper[0]).attr('data-type')
          if (itemType === 'food') {
            originSectionEl
              .draggable('option', 'disabled', true)
              .addClass('r_text-gray-400')
            $(ui.helper[0]).append(
              '<span class="rjs_removeItem re_remove-food-item r_cursor-pointer hover:r_opacity-70" style="position: absolute; top:2px; right:2px;"><span class="dashicons dashicons-no-alt"></span></span>'
            )
          }
          // text items
          if (itemType === 'heading' || itemType === 'paragraph') {
            $(ui.helper[0]).append(
              '<span class="rjs_saveItemText re_save-item-text r_cursor-pointer hover:r_opacity-70" style="display: none; position: absolute; top:4px; right:4px;"><span class="dashicons dashicons-saved"></span></span>'
            )
            $(ui.helper[0]).append(
              '<span class="rjs_removeItem re_remove-misc-item r_cursor-pointer hover:r_opacity-70" style="position: absolute; top:4px; right:2px;"><span class="dashicons dashicons-no-alt"></span></span>'
            )
            $(ui.helper[0]).append(
              '<span class="rjs_editItemText re_edit-item-text r_cursor-pointer hover:r_opacity-70" style="position: absolute; top:4px; right:20px;"><span class="dashicons dashicons-edit"></span></span>'
            )
          }
        }
        updateMenuData()
      },
      stop: function (event, ui) {
        updateMenuData()
      },
    })
  }

  // initialize item dragging (from lists)
  function initItemDragging() {
    $('.rjs_item').draggable({
      helper: 'clone',
      connectToSortable: '.rjs_menuSection',
    })
  }
  initItemDragging()

  // initialize menu layout
  function initMenuLayout() {
    let nbOfColumns = menuSettings.layout
    $('.rjs_menuSections').addClass('r_grid-cols-' + nbOfColumns)
  }
  initMenuLayout()

  // switch menu layout
  function switchMenuLayout() {
    let currentLayout = menuSettings.layout
    if (currentLayout === 1) {
      currentLayout = 2
      $('.rjs_menuSections')
        .removeClass('r_grid-cols-1')
        .addClass('r_grid-cols-2')
      updateMenuSetting('layout', 2)
    } else if (currentLayout === 2) {
      currentLayout = 3
      $('.rjs_menuSections')
        .removeClass('r_grid-cols-2')
        .addClass('r_grid-cols-3')
      updateMenuSetting('layout', 3)
    } else {
      currentLayout = 1
      $('.rjs_menuSections')
        .removeClass('r_grid-cols-3')
        .addClass('r_grid-cols-1')
      updateMenuSetting('layout', 1)
    }
  }
  $('body').on('click', '.rjs_menuSectionLayout', switchMenuLayout)

  // initialize shFoodImages
  function initShFoodImages() {
    let shFoodImages = menuSettings.sh_food_images
    $('.rjs_shFoodImages').val(shFoodImages)
  }
  initShFoodImages()

  // update shFoodImages
  function updateShFoodImages() {
    updateMenuSetting('sh_food_images', $('.rjs_shFoodImages').val())
  }
  $('body').on('change', '.rjs_shFoodImages', updateShFoodImages)

  // initialize foodImageShape
  function initfoodImageShape() {
    let foodImageShape = menuSettings.food_image_shape
    $('.rjs_foodImageShape').val(foodImageShape)
  }
  initfoodImageShape()

  // update foodImageShape
  function updatefoodImageShape() {
    updateMenuSetting('food_image_shape', $('.rjs_foodImageShape').val())
  }
  $('body').on('change', '.rjs_foodImageShape', updatefoodImageShape)

  // initialize foodImageSize
  function initfoodImageSize() {
    let foodImageSize = menuSettings.food_image_size
    $('.rjs_foodImageSize').val(foodImageSize)
  }
  initfoodImageSize()

  // update foodImageSize
  function updatefoodImageSize() {
    updateMenuSetting('food_image_size', $('.rjs_foodImageSize').val())
  }
  $('body').on('change', '.rjs_foodImageSize', updatefoodImageSize)

  // enter full screen mode
  function enterfullScreen() {
    $('html').css('overflow', 'hidden')
    $('.rjs_menuEditor').addClass('re_fullscreen-editor')
    $('.rjs_backdrop').removeClass('r_hidden')
    $('.rjs_exitFullScreen').removeClass('r_hidden').addClass('r_flex')
    $('.rjs_enterFullScreen').addClass('r_hidden').removeClass('r_flex')
  }
  $('body').on('click', '.rjs_enterFullScreen', enterfullScreen)

  // exit full screen mode
  function exitFullScreen() {
    $('html').css('overflow', 'auto')
    $('.rjs_menuEditor').removeClass('re_fullscreen-editor')
    $('.rjs_backdrop').addClass('r_hidden')
    $('.rjs_enterFullScreen').addClass('r_flex').removeClass('r_hidden')
    $('.rjs_exitFullScreen').addClass('r_hidden').removeClass('r_flex')
  }
  $('body').on('click', '.rjs_exitFullScreen', exitFullScreen)

  // exit fullscreen if press esc key
  $(document).keyup(function (e) {
    if (e.keyCode === 27) {
      exitFullScreen()
    }
  })

  // setup interface from data
  function createInterfaceFromData() {
    let data = JSON.parse($('.rjs_dataDump').val())
    // loop through sections
    for (let i = 0; i < data.length; i++) {
      // clone empty section
      let section = $('.rjs_menuSectionEmpty')
        .clone(false)
        .removeClass('rjs_menuSectionEmpty r_hidden')
        .addClass('rjs_menuSection r_block')
        .appendTo('.rjs_menuSections')
      // loop through section items
      for (let j = 0; j < data[i].length; j++) {
        item = data[i][j]
        if (item.type === 'food') {
          // clone food item from food list
          $('.rjs_foodItemList .rjs_item[data-food-id=' + item.id + ']')
            .clone(false)
            .appendTo(section)
            .append(
              '<span class="rjs_removeItem re_remove-food-item r_cursor-pointer hover:r_opacity-70" style="position: absolute; top:4px; right:2px;"><span class="dashicons dashicons-no-alt"></span></span>'
            )
          disableFoodItemDragging(item.id)
        }
        if (item.type === 'heading' || item.type === 'paragraph') {
          // clone heading item from list
          $('.rjs_miscItemList .rjs_item[data-type="' + item.type + '"]')
            .clone(false)
            .appendTo(section)
            .append(
              '<span class="rjs_saveItemText re_save-item-text r_cursor-pointer hover:r_opacity-70" style="display: none; position: absolute; top:4px; right:4px;"><span class="dashicons dashicons-saved"></span></span>'
            )
            .append(
              '<span class="rjs_removeItem re_remove-misc-item r_cursor-pointer hover:r_opacity-70" style="position: absolute; top:4px; right:2px;"><span class="dashicons dashicons-no-alt"></span></span>'
            )
            .append(
              '<span class="rjs_editItemText re_edit-item-text r_cursor-pointer hover:r_opacity-70" style="position: absolute; top:4px; right:20px;"><span class="dashicons dashicons-edit"></span></span>'
            )
            .find('.rjs_itemTextContent')
            .html(item.content)
        }
      }
    }
    initItemSorting()
    checkSectionNotice()
  }
  createInterfaceFromData()
})
