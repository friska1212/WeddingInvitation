package com.example.musicfinder.ui

import android.media.MediaPlayer
import android.net.Uri
import androidx.compose.foundation.Image
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.PlayArrow
import androidx.compose.material.icons.filled.Pause
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.platform.LocalLifecycleOwner
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import coil.compose.AsyncImage
import java.net.URLDecoder
import androidx.lifecycle.Lifecycle
import androidx.lifecycle.LifecycleEventObserver

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SongDetailScreen(
    title: String,
    artist: String,
    image: String,
    preview: String
) {
    // decode URL-encoded strings (nav passes encoded params)
    val decodedTitle = try { URLDecoder.decode(title, "UTF-8") } catch (_: Exception) { title ?: "" }
    val decodedArtist = try { URLDecoder.decode(artist, "UTF-8") } catch (_: Exception) { artist ?: "" }
    val decodedImage = try { URLDecoder.decode(image, "UTF-8") } catch (_: Exception) { image ?: "" }
    val decodedPreview = try { URLDecoder.decode(preview, "UTF-8") } catch (_: Exception) { preview ?: "" }

    val context = LocalLifecycleOwner.current

    var isPlaying by remember { mutableStateOf(false) }
    var mediaPlayer by remember { mutableStateOf<MediaPlayer?>(null) }

    // release media player when lifecycle ON_DESTROY
    DisposableEffect(context.lifecycle) {
        val observer = LifecycleEventObserver { _, event ->
            if (event == Lifecycle.Event.ON_DESTROY) {
                mediaPlayer?.stop()
                mediaPlayer?.release()
                mediaPlayer = null
            }
        }
        context.lifecycle.addObserver(observer)
        onDispose {
            context.lifecycle.removeObserver(observer)
            mediaPlayer?.stop()
            mediaPlayer?.release()
            mediaPlayer = null
        }
    }

    Scaffold { innerPadding ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(innerPadding)
                .padding(16.dp)
        ) {
            // Cover image
            AsyncImage(
                model = if (decodedImage.isNotBlank()) decodedImage else null,
                contentDescription = decodedTitle,
                modifier = Modifier
                    .fillMaxWidth()
                    .height(260.dp)
                    .clip(RoundedCornerShape(12.dp))
            )

            Spacer(modifier = Modifier.height(12.dp))

            // Title & artist
            Text(
                text = if (decodedTitle.isNotBlank()) decodedTitle else "Unknown Title",
                style = MaterialTheme.typography.headlineSmall,
                fontWeight = FontWeight.Bold
            )
            Spacer(modifier = Modifier.height(4.dp))
            Text(
                text = if (decodedArtist.isNotBlank()) decodedArtist else "Unknown Artist",
                style = MaterialTheme.typography.bodyMedium,
                color = MaterialTheme.colorScheme.onSurface.copy(alpha = 0.7f)
            )

            Spacer(modifier = Modifier.height(18.dp))

            // Placeholder for album/genre (we don't have these fields unless you add them to Song)
            Text(
                text = "Album: —",
                style = MaterialTheme.typography.bodySmall
            )
            Text(
                text = "Genre: —",
                style = MaterialTheme.typography.bodySmall
            )

            Spacer(modifier = Modifier.height(24.dp))

            // Player controls
            Row(verticalAlignment = Alignment.CenterVertically) {
                Button(
                    onClick = {
                        // toggle play/pause
                        if (!isPlaying) {
                            // start playing
                            try {
                                val mp = MediaPlayer().apply {
                                    setDataSource(decodedPreview)
                                    prepareAsync()
                                    setOnPreparedListener {
                                        start()
                                        isPlaying = true
                                    }
                                    setOnCompletionListener {
                                        isPlaying = false
                                    }
                                }
                                mediaPlayer?.stop()
                                mediaPlayer?.release()
                                mediaPlayer = mp
                            } catch (e: Exception) {
                                // gagal play
                                e.printStackTrace()
                            }
                        } else {
                            // stop
                            mediaPlayer?.stop()
                            mediaPlayer?.release()
                            mediaPlayer = null
                            isPlaying = false
                        }
                    },
                    modifier = Modifier.size(56.dp),
                    shape = RoundedCornerShape(12.dp),
                    colors = ButtonDefaults.buttonColors(containerColor = MaterialTheme.colorScheme.primary)
                ) {
                    Icon(
                        imageVector = if (isPlaying) Icons.Default.Pause else Icons.Default.PlayArrow,
                        contentDescription = if (isPlaying) "Pause" else "Play",
                        tint = MaterialTheme.colorScheme.onPrimary
                    )
                }

                Spacer(modifier = Modifier.width(12.dp))

                Column {
                    Text(
                        text = if (decodedTitle.isNotBlank()) decodedTitle else "Unknown Title",
                        style = MaterialTheme.typography.titleMedium
                    )
                    Text(
                        text = if (decodedArtist.isNotBlank()) decodedArtist else "Unknown Artist",
                        style = MaterialTheme.typography.bodySmall,
                        color = MaterialTheme.colorScheme.onSurface.copy(alpha = 0.7f)
                    )
                }
            }
        }
    }
}