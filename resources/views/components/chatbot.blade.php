<!-- Chatbot Modal -->
<div class="modal fade" id="chatbotModal" tabindex="-1" aria-labelledby="chatbotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="height: 600px; display: flex; flex-direction: column;">
            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-chat-dots"></i>
                    <h5 class="modal-title" id="chatbotModalLabel">File Search Assistant</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Chat Body -->
            <div class="modal-body flex-grow-1 d-flex flex-column" style="overflow-y: auto;">
                <div id="chatbotMessages" class="flex-grow-1 mb-3" style="overflow-y: auto; display: flex; flex-direction: column;">
                    <!-- Welcome message -->
                    <div class="mb-3">
                        <div class="d-flex gap-2">
                            <div class="bg-light p-3 rounded" style="max-width: 80%; border-radius: 10px;">
                                <strong>Bot:</strong> Halo! 👋 Saya adalah asisten untuk mencari file. Anda bisa tanya:
                                <ul class="mt-2 mb-0 small">
                                    <li>Cari file bernama "SOP"</li>
                                    <li>Berapa file di kategori Marketing?</li>
                                    <li>Tampilkan file terbaru</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Input area -->
                <div class="input-group">
                    <input 
                        type="text" 
                        id="chatbotInput" 
                        class="form-control" 
                        placeholder="Ketik pertanyaan atau cari file..."
                        autocomplete="off"
                    />
                    <button class="btn btn-primary" id="chatbotSendBtn" type="button">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chatbot Toggle Button (floating) -->
<button 
    id="chatbotToggleBtn" 
    class="btn btn-primary rounded-circle shadow" 
    style="position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; z-index: 999; font-size: 24px;"
    data-bs-toggle="modal" 
    data-bs-target="#chatbotModal"
    title="Buka File Search Assistant"
>
    <i class="bi bi-chat-dots"></i>
</button>
