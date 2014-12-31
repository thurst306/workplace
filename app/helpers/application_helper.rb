module ApplicationHelper

    def header(page_header)
        content_for(:header) { page_header }
    end 
    
    def cp(path)
        "active" if current_page?(path)
    end 

end
