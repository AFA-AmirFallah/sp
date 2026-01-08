<script>
    var $task_id_on_edit;

    function intEditTaskEvents(task_id) {
        $task_id_on_edit = task_id;
        const textarea = document.getElementById('autoSizeTextarea');
        const progressContainer = document.getElementById("progress-container");
        const progressBar = document.getElementById("progress-bar");
        const percentDisplay = document.getElementById("selected-percent");
        if (!progressContainer || !progressBar || !percentDisplay) {
            console.warn("Modal elements not found.");
            return;
        }
        progressContainer.addEventListener("click", function(e) {
            const rect = progressContainer.getBoundingClientRect();
            const x = rect.right - e.clientX; // از راست به چپ
            const width = rect.width;
            let percent = Math.round((x / width) * 100);
            percent = Math.max(0, Math.min(100, percent));
            progressBar.style.width = percent + "%";
            percentDisplay.textContent = percent + "٪";
        });
    }


    function savetask() {
        let widthStr = $('#progress-bar').css('width'); // مثلاً "45px"
        let containerWidth = $('#progress-container').width(); // پهنای کل نوار
        let percent = Math.round((parseFloat(widthStr) / containerWidth) * 100);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('', {
                AjaxType: 'do_edit_task',
                progress: percent,
                task_id:$task_id_on_edit
            },

            function(data, status) {
                alert(data);
            });

    }
    function switch_edit_mode(){
        $('.edit_part').removeClass('d-none');
        
    }
</script>
