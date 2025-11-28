package com.example.musicapp.ui

import android.media.MediaPlayer
import androidx.compose.foundation.background
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Search
import androidx.compose.material.icons.filled.PlayArrow
import androidx.compose.material.icons.filled.Pause
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Brush
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.input.ImeAction
import androidx.compose.ui.unit.dp
import coil.compose.AsyncImage
import com.example.musicapp.api.RetrofitClient
import com.example.musicapp.api.Song
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.launch
import androidx.compose.foundation.text.KeyboardActions
import androidx.compose.foundation.text.KeyboardOptions


@Composable
fun MusicDashboard() {

    var search by remember { mutableStateOf("") }
    var songs by remember { mutableStateOf<List<Song>>(emptyList()) }
    var loading by remember { mutableStateOf(false) }
    var error by remember { mutableStateOf("") }

    var player by remember { mutableStateOf<MediaPlayer?>(null) }
    var playingUrl by remember { mutableStateOf<String?>(null) }

    val scope = rememberCoroutineScope()

    Column(
        modifier = Modifier
            .fillMaxSize()
            .padding(16.dp)
    ) {

        // HEADER GRADIENT
        Box(
            modifier = Modifier
                .fillMaxWidth()
                .height(120.dp)
                .clip(RoundedCornerShape(20.dp))
                .background(
                    Brush.verticalGradient(
                        listOf(
                            MaterialTheme.colorScheme.primary,
                            MaterialTheme.colorScheme.secondary
                        )
                    )
                ),
            contentAlignment = Alignment.Center
        ) {
            Text(
                "MusicApp 🎵",
                style = MaterialTheme.typography.headlineMedium.copy(
                    color = Color.White,
                    fontWeight = FontWeight.Bold
                )
            )
        }

        Spacer(Modifier.height(20.dp))

        // SEARCH BAR
        OutlinedTextField(
            value = search,
            onValueChange = {
                search = it
                if (search.isBlank()) songs = emptyList()
            },
            modifier = Modifier.fillMaxWidth(),
            label = { Text("Search Song or Artist") },
            trailingIcon = { Icon(Icons.Default.Search, null) },
            singleLine = true,
            keyboardOptions = KeyboardOptions(imeAction = ImeAction.Search),
            keyboardActions = KeyboardActions(
                onSearch = {
                    performSearch(search, scope, { loading = it }, { songs = it }, { error = it })
                }
            )
        )

        Spacer(Modifier.height(12.dp))

        // SEARCH BUTTON
        Button(
            onClick = {
                performSearch(search, scope, { loading = it }, { songs = it }, { error = it })
            },
            modifier = Modifier.fillMaxWidth(),
            shape = RoundedCornerShape(12.dp)
        ) {
            Text("Search")
        }

        Spacer(Modifier.height(16.dp))

        if (loading) {
            CircularProgressIndicator(Modifier.align(Alignment.CenterHorizontally))
        }

        if (error.isNotEmpty()) {
            Text(error, color = MaterialTheme.colorScheme.error)
        }

        // Song List
        LazyColumn {
            items(songs) { song ->
                SongCard(
                    song = song,
                    isPlaying = (playingUrl == song.previewUrl),
                    onPlayPause = {
                        player?.stop()
                        player?.release()
                        player = null

                        if (playingUrl == song.previewUrl) {
                            playingUrl = null
                            return@SongCard
                        }

                        val mp = MediaPlayer().apply {
                            setDataSource(song.previewUrl)
                            prepareAsync()
                            setOnPreparedListener { start() }
                        }

                        player = mp
                        playingUrl = song.previewUrl
                    }
                )
            }
        }
    }
}

fun performSearch(
    query: String,
    scope: CoroutineScope,
    setLoading: (Boolean) -> Unit,
    setSongs: (List<Song>) -> Unit,
    setError: (String) -> Unit
) {
    if (query.isBlank()) return

    setLoading(true)
    setError("")

    scope.launch {
        try {
            val result = RetrofitClient.instance.searchSongs(query)
            setSongs(result.results)
        } catch (e: Exception) {
            setError("Gagal mengambil data")
        }
        setLoading(false)
    }
}

@Composable
fun SongCard(
    song: Song,
    isPlaying: Boolean,
    onPlayPause: () -> Unit
) {
    Card(
        modifier = Modifier
            .fillMaxWidth()
            .padding(vertical = 8.dp),
        shape = RoundedCornerShape(16.dp),
        elevation = CardDefaults.cardElevation(6.dp)
    ) {
        Row(
            modifier = Modifier.padding(14.dp),
            verticalAlignment = Alignment.CenterVertically
        ) {
            AsyncImage(
                model = song.artworkUrl100,
                contentDescription = null,
                modifier = Modifier
                    .size(75.dp)
                    .clip(RoundedCornerShape(12.dp))
            )

            Spacer(Modifier.width(12.dp))

            Column(Modifier.weight(1f)) {
                Text(song.trackName ?: "-", fontWeight = FontWeight.Bold)
                Text(song.artistName ?: "-", color = Color.Gray)
            }

            IconButton(onClick = onPlayPause) {
                Icon(
                    imageVector = if (isPlaying) Icons.Default.Pause else Icons.Default.PlayArrow,
                    contentDescription = null
                )
            }
        }
    }
}