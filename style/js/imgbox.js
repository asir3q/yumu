document.addEventListener('DOMContentLoaded', () => {
  const galleryModal = document.getElementById('galleryModal');
  const galleryMainImage = document.getElementById('galleryMainImage');
  const galleryThumbnails = document.getElementById('galleryThumbnails');
  
  let currentIndex = 0;
  let allImages = [];
  
  // 1. 初始化图片事件监听
  function initGallery() {
    const articleImages = document.querySelectorAll('.post-main img');
    allImages = Array.from(articleImages);
    console.log("333");
    articleImages.forEach((img, index) => {
      img.addEventListener('click', () => openGallery(index));
    });
  }
  
  // 2. 打开相册
  function openGallery(clickedIndex) {
    currentIndex = clickedIndex;
    updateMainImage();
    createThumbnails();
    galleryModal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    // 确保缩略图区域滚动到当前选中图片
    setTimeout(() => {
      const activeThumb = document.querySelector('.gallery-thumb.active');
      if (activeThumb) {
        activeThumb.scrollIntoView({ 
          behavior: 'smooth', 
          block: 'nearest',
          inline: 'center'
        });
      }
    }, 100);
  }
  
  // 3. 更新主显示区大图
  function updateMainImage() {
    if (!allImages[currentIndex]) return;
    
    galleryMainImage.src = allImages[currentIndex].src;
    galleryMainImage.alt = allImages[currentIndex].alt;
    
    // 为图片加载添加过渡效果
    galleryMainImage.style.opacity = 0;
    setTimeout(() => {
      galleryMainImage.style.opacity = 1;
    }, 10);
    
    // 更新缩略图选中状态
    const thumbs = document.querySelectorAll('.gallery-thumb');
    thumbs.forEach((thumb, idx) => {
      thumb.classList.toggle('active', idx === currentIndex);
    });
  }
  
  // 4. 创建缩略图列表
  function createThumbnails() {
    galleryThumbnails.innerHTML = '';
    
    allImages.forEach((img, index) => {
      const thumb = document.createElement('img');
      thumb.className = 'gallery-thumb';
      thumb.src = img.src;
      thumb.alt = `${img.alt}`;
      
      if (index === currentIndex) {
        thumb.classList.add('active');
      }
      
      thumb.addEventListener('click', (e) => {
        e.stopPropagation();
        currentIndex = index;
        updateMainImage();
      });
      
      galleryThumbnails.appendChild(thumb);
    });
  }
  
  // 5. 导航功能
  function prevImage() {
    currentIndex = (currentIndex - 1 + allImages.length) % allImages.length;
    updateMainImage();
    scrollToCurrentThumb();
  }
  
  function nextImage() {
    currentIndex = (currentIndex + 1) % allImages.length;
    updateMainImage();
    scrollToCurrentThumb();
  }
  
  // 滚动到当前缩略图
  function scrollToCurrentThumb() {
    const activeThumb = document.querySelector('.gallery-thumb.active');
    if (activeThumb) {
      activeThumb.scrollIntoView({ 
        behavior: 'smooth', 
        block: 'nearest',
        inline: 'center'
      });
    }
  }
  
  // 6. 关闭相册
  function closeGallery() {
    galleryModal.style.display = 'none';
    document.body.style.overflow = '';
  }
  
  // 7. 键盘导航事件
  function handleKeyDown(e) {
    if (!galleryModal.style.display || galleryModal.style.display === 'none') return;
    
    switch(e.key) {
      case 'ArrowLeft':
      case 'ArrowUp': // 上箭头也切换到上一张
        prevImage();
        break;
      case 'ArrowRight':
      case 'ArrowDown': // 下箭头也切换到下一张
        nextImage();
        break;
      case 'Escape':
        closeGallery();
        break;
    }
  }
  
  // 8. 鼠标滚轮事件处理
  function handleWheel(e) {
    if (!galleryModal.style.display || galleryModal.style.display === 'none') return;
    
    // 阻止默认滚动行为
    e.preventDefault();
    
    // 判断滚轮方向
    if (e.deltaY < 0) {
      // 向上滚动 - 上一张
      prevImage();
    } else if (e.deltaY > 0) {
      // 向下滚动 - 下一张
      nextImage();
    }
  }
  
  // 9. 绑定事件监听器
  function bindEvents() {
    document.querySelector('.gallery-prev').addEventListener('click', prevImage);
    document.querySelector('.gallery-next').addEventListener('click', nextImage);
    
    document.querySelector('.gallery-close').addEventListener('click', closeGallery);
    
    galleryModal.addEventListener('click', (e) => {
      if (e.target === galleryModal) closeGallery();
    });
    
    // 键盘事件
    document.addEventListener('keydown', handleKeyDown);
    
    // 鼠标滚轮事件
    document.addEventListener('wheel', handleWheel, { passive: false });
  }
  
  initGallery();
  bindEvents();
});