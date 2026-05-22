// Chatbot File Search Assistant
class ChatbotAssistant {
    constructor() {
        this.messagesContainer = document.getElementById('chatbotMessages');
        this.inputField = document.getElementById('chatbotInput');
        this.sendButton = document.getElementById('chatbotSendBtn');
        this.modal = document.getElementById('chatbotModal');
        
        this.setupEventListeners();
        this.conversationHistory = [];
    }

    setupEventListeners() {
        this.sendButton.addEventListener('click', () => this.handleUserInput());
        this.inputField.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.handleUserInput();
            }
        });
    }

    async handleUserInput() {
        const userInput = this.inputField.value.trim();
        
        if (!userInput) return;

        // Add user message to chat
        this.addMessage(userInput, 'user');
        this.inputField.value = '';
        this.sendButton.disabled = true;

        // Process query and get response
        await this.processQuery(userInput);
        
        this.sendButton.disabled = false;
        this.inputField.focus();
    }

    async processQuery(query) {
        // Determine what user is asking
        const queryLower = query.toLowerCase();
        
        try {
            // Check if user is searching for files
            if (queryLower.includes('cari') || queryLower.includes('search') || 
                queryLower.includes('find') || queryLower.includes('file')) {
                await this.searchFiles(query);
            } 
            // Check if user is asking for statistics
            else if (queryLower.includes('berapa') || queryLower.includes('total') || 
                     queryLower.includes('statistik') || queryLower.includes('stats')) {
                await this.showStatistics();
            }
            // Check if user is asking for recent files
            else if (queryLower.includes('terbaru') || queryLower.includes('recent') || 
                     queryLower.includes('terakhir') || queryLower.includes('latest')) {
                await this.showRecentFiles();
            }
            // Check if user is asking for categories
            else if (queryLower.includes('kategori') || queryLower.includes('category') || 
                     queryLower.includes('jenis')) {
                await this.showCategories();
            }
            // Default: try to search by keyword
            else {
                await this.searchFiles(query);
            }
        } catch (error) {
            this.addMessage(`Error: ${error.message}`, 'bot');
        }
    }

    async searchFiles(query) {
        try {
            // Extract search keyword (remove 'cari', 'search', etc)
            let searchKeyword = query
                .replace(/cari\s+/gi, '')
                .replace(/search\s+/gi, '')
                .replace(/find\s+/gi, '')
                .replace(/file\s+/gi, '')
                .trim();

            if (!searchKeyword) {
                this.addMessage('Silakan masukkan keyword untuk pencarian (contoh: "cari SOP")', 'bot');
                return;
            }

            const response = await fetch('/api/chatbot/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ query: searchKeyword })
            });

            const data = await response.json();

            if (!data.success) {
                this.addMessage(data.message, 'bot');
                return;
            }

            if (!data.found || data.files.length === 0) {
                this.addMessage(`😟 Tidak ada file yang ditemukan untuk: "${searchKeyword}"`, 'bot');
                return;
            }

            // Format file results dengan buttons
            let filesHtml = `✅ <strong>Ditemukan ${data.files.length} file:</strong><br/><br/>`;
            
            data.files.forEach((file, index) => {
                filesHtml += `<div style="margin-bottom: 15px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: #f9f9f9;">`;
                filesHtml += `<strong>${index + 1}. ${file.name}</strong><br/>`;
                filesHtml += `📁 Kategori: ${file.category}<br/>`;
                filesHtml += `📂 Departemen: ${file.department}<br/>`;
                filesHtml += `📦 Ukuran: ${file.size}<br/>`;
                filesHtml += `📅 Tanggal: ${file.uploadedAt}<br/>`;
                filesHtml += `<div style="margin-top: 8px; display: flex; gap: 8px;">`;
                filesHtml += `<button class="btn btn-sm btn-primary" onclick="downloadFile('${file.id}', '${file.name.replace(/'/g, "\\'")}')"><i class="bi bi-download"></i> Download</button>`;
                filesHtml += `<button class="btn btn-sm btn-info" onclick="viewFile('${file.id}', '${file.name.replace(/'/g, "\\'")}')"><i class="bi bi-eye"></i> View</button>`;
                filesHtml += `</div>`;
                filesHtml += `</div>`;
            });

            this.addMessage(filesHtml, 'bot', true);

        } catch (error) {
            this.addMessage(`Error saat mencari file: ${error.message}`, 'bot');
        }
    }

    async showStatistics() {
        try {
            const response = await fetch('/api/chatbot/stats', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (!data.success) {
                this.addMessage('Error mengambil statistik', 'bot');
                return;
            }

            const stats = data.stats;
            let message = `📊 **Statistik File System:**\n\n`;
            message += `📁 Total File: **${stats.total_files}** file\n`;
            message += `🏷️ Total Kategori: **${stats.total_categories}** kategori\n`;
            message += `\n📌 File Terbaru:\n`;
            
            if (stats.recent_files && stats.recent_files.length > 0) {
                stats.recent_files.forEach(file => {
                    message += `• ${file}\n`;
                });
            } else {
                message += `Belum ada file terbaru\n`;
            }

            this.addMessage(message, 'bot');

        } catch (error) {
            this.addMessage(`Error: ${error.message}`, 'bot');
        }
    }

    async showRecentFiles() {
        try {
            const response = await fetch('/api/chatbot/stats', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (!data.success) {
                this.addMessage('Error mengambil file terbaru', 'bot');
                return;
            }

            const recentFiles = data.stats.recent_files;
            let message = `📌 **File Terbaru:**\n\n`;
            
            if (recentFiles && recentFiles.length > 0) {
                recentFiles.forEach((file, index) => {
                    message += `${index + 1}. ${file}\n`;
                });
            } else {
                message += `Belum ada file terbaru`;
            }

            this.addMessage(message, 'bot');

        } catch (error) {
            this.addMessage(`Error: ${error.message}`, 'bot');
        }
    }

    async showCategories() {
        try {
            const response = await fetch('/api/chatbot/categories', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (!data.success) {
                this.addMessage('Error mengambil kategori', 'bot');
                return;
            }

            const categories = data.categories;
            let message = `🏷️ **Kategori File yang Tersedia:**\n\n`;
            
            if (categories && categories.length > 0) {
                categories.forEach((cat, index) => {
                    message += `${index + 1}. ${cat.name}\n`;
                });
            } else {
                message += `Tidak ada kategori`;
            }

            this.addMessage(message, 'bot');

        } catch (error) {
            this.addMessage(`Error: ${error.message}`, 'bot');
        }
    }

    addMessage(text, sender, isHtml = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'mb-3 d-flex gap-2';
        
        if (sender === 'user') {
            messageDiv.className += ' justify-content-end';
            messageDiv.innerHTML = `
                <div class="bg-primary text-white p-3 rounded" style="max-width: 80%; border-radius: 10px;">
                    ${this.escapeHtml(text)}
                </div>
            `;
        } else {
            if (isHtml) {
                // Direct HTML content (for file results with buttons)
                messageDiv.innerHTML = `
                    <div class="bg-light p-3 rounded" style="max-width: 90%; border-radius: 10px;">
                        <strong>Bot:</strong><br/>
                        ${text}
                    </div>
                `;
            } else {
                // Markdown-like text content
                messageDiv.innerHTML = `
                    <div class="bg-light p-3 rounded" style="max-width: 80%; border-radius: 10px;">
                        <strong>Bot:</strong><br/>
                        ${this.formatMessage(text)}
                    </div>
                `;
            }
        }

        this.messagesContainer.appendChild(messageDiv);
        
        // Scroll to bottom
        setTimeout(() => {
            this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
        }, 0);
    }

    formatMessage(text) {
        // Convert markdown-like syntax to HTML
        text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        text = text.replace(/\n/g, '<br/>');
        return text;
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Global functions for file actions
function downloadFile(fileId, fileName) {
    // Redirect to download endpoint
    window.location.href = `/file/${fileId}/download`;
}

function viewFile(fileId, fileName) {
    // Open file in new tab
    window.open(`/file/${fileId}/view`, '_blank');
}

// Initialize chatbot when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const chatbot = new ChatbotAssistant();
});
