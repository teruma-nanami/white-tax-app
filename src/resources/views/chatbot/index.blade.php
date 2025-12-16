@extends('layouts.app')

@section('title', 'チャットボット')

@section('content')
  <div class="container py-4">

    <h1 class="h4 mb-3">チャットボット</h1>
    <p class="text-muted small mb-4">
      会計・税務に関する質問を入力すると、このアプリ専用のサポートAIが回答します。
    </p>

    <div class="row">
      <div class="col-md-8">

        {{-- チャットエリア --}}
        <div id="chat-window" class="border rounded p-3 mb-3" style="height: 400px; overflow-y: auto; background: #fafafa;">
          {{-- メッセージがここにJSで追加される --}}
        </div>

        {{-- 入力フォーム --}}
        <form id="chat-form">
          @csrf
          <div class="mb-2">
            <label for="question" class="form-label">質問内容</label>
            <textarea id="question" name="question" class="form-control" rows="3" placeholder="例）青色申告と白色申告の違いを教えてください"></textarea>
          </div>

          <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary" id="send-button">
              送信
            </button>
            <span class="text-muted small" id="status-text"></span>
          </div>
        </form>

      </div>
    </div>

  </div>

  <script>
    (() => {
      const form = document.getElementById('chat-form');
      const questionInput = document.getElementById('question');
      const chatWindow = document.getElementById('chat-window');
      const sendButton = document.getElementById('send-button');
      const statusText = document.getElementById('status-text');

      const csrfToken = document.querySelector('meta[name="csrf-token"]') ?
        document.querySelector('meta[name="csrf-token"]').getAttribute('content') :
        document.querySelector('input[name="_token"]').value;

      const appendMessage = (role, text) => {
        const wrapper = document.createElement('div');
        wrapper.classList.add('mb-2');

        const badge = document.createElement('span');
        badge.classList.add('badge', 'me-2');
        if (role === 'user') {
          badge.classList.add('bg-primary');
          badge.textContent = 'あなた';
        } else {
          badge.classList.add('bg-secondary');
          badge.textContent = 'AI';
        }

        const body = document.createElement('span');
        body.textContent = text;

        wrapper.appendChild(badge);
        wrapper.appendChild(body);
        chatWindow.appendChild(wrapper);

        // 一番下までスクロール
        chatWindow.scrollTop = chatWindow.scrollHeight;
      };

      form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const question = questionInput.value.trim();
        if (!question) {
          alert('質問を入力してください。');
          return;
        }

        appendMessage('user', question);
        questionInput.value = '';

        sendButton.disabled = true;
        statusText.textContent = 'AIが考えています…';

        try {
          const response = await fetch('{{ route('chatbot.message') }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken,
              'Accept': 'application/json',
            },
            body: JSON.stringify({
              question
            }),
          });

          const data = await response.json();

          appendMessage('assistant', data.answer ?? '回答を取得できませんでした。');
        } catch (error) {
          console.error(error);
          appendMessage('assistant', 'エラーが発生しました。時間をおいて再度お試しください。');
        } finally {
          sendButton.disabled = false;
          statusText.textContent = '';
          questionInput.focus();
        }
      });
    })();
  </script>
@endsection
