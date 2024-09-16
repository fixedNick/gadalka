document.addEventListener('DOMContentLoaded', function() {
    const popular_posts = document.querySelector('.popular-posts');
    const banners = document.querySelector('.banners');
    
    let big = window.innerWidth <= 700 ? false : true;
    if(big == false) {
        document.querySelector('.sidebar').removeChild(popular_posts);
        document.querySelector('.sidebar').removeChild(banners);
        document.querySelector('.blog-section').appendChild(popular_posts);
        document.querySelector('.blog-section').appendChild(banners);
    }
            
    window.addEventListener('resize', function() {
        const sidebar = document.querySelector('.sidebar');
        const blog_section = document.querySelector('.blog-section');

        if (this.window.innerWidth <= 700 && big) {
            big = false;
            if(sidebar.contains(popular_posts))
                sidebar.removeChild(popular_posts);
            if(sidebar.contains(banners))
                sidebar.removeChild(banners);
            if(!blog_section.contains(popular_posts))
                blog_section.appendChild(popular_posts);
            if(!blog_section.contains(banners)) 
                blog_section.appendChild(banners);
            return;
        }
        else if (this.window.innerWidth > 700 && !big){
            big = true;
            if(!sidebar.contains(popular_posts))
                sidebar.appendChild(popular_posts);
            if(!sidebar.contains(banners))
                sidebar.appendChild(banners);
            if(blog_section.contains(popular_posts))
                blog_section.removeChild(popular_posts);
            if(blog_section.contains(banners)) 
                blog_section.removeChild(banners);
            return;
        }
    });
});